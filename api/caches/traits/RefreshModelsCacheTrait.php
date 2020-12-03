<?php


namespace api\caches\traits;


use api\caches\interfaces\CacheInterface;
use yii\base\UserException;

/**
 * Trait RefreshModelsCacheTrait
 * @package api\modules\broker\caches\traits
 *
 * 该类依赖模型处理，如果直接用Yii::$app->db操作的都清不了缓存
 */
trait RefreshModelsCacheTrait
{
    /**
     * 使用的缓存类
     * @var string
     */
    public static $cacheClass;

    /**
     * 实例化缓存类
     * @return CacheInterface
     * @throws UserException
     */
    private static function newCacheClass()
    {
        $cacheClass = self::$cacheClass;
        if (!$cacheClass) {// 没设置，尝试自动加载
            $lastBackslash = strrpos(self::class, '\\');
            $cacheNamespace = rtrim(substr(self::class, 0, $lastBackslash), 'models');
            $modelName = trim(substr(self::class, $lastBackslash), '\\');

            $cacheClass = $cacheNamespace. 'caches\\' . $modelName . 'Cache';
            if (!class_exists($cacheClass)) {
                \Yii::error($cacheClass);
                throw new UserException('请设置缓存类');
            }
        }

        return new $cacheClass();
    }

    /**
     * 清除缓存
     * @param $model
     * @param $delimiter
     */
    public static function clearCache($model, $delimiter = '_')
    {
        // 清理缓存有问题，不影响主流程，只通报
        try {
            $obj = self::newCacheClass();

            if (empty($obj->groupDbFields())) {
                $obj->delData();
                return;
            }

            $group = '';
            foreach ($obj->groupDbFields() as $field) {

                if ($model->hasAttribute($field) && $model->$field !== null) {
                    $group .= $model->$field . $delimiter;
                }

            }
            $obj->setGroup(trim($group, $delimiter));
            $obj->delData();
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
        }
    }

    /**
     * 批量清除缓存
     * @param string $condition
     * @param string $delimiter
     * @param array $params
     */
    public static function batchClearCache($condition = '', $params = [], $delimiter = '_')
    {
        try {
            $obj = self::newCacheClass();

            if (empty($obj->groupDbFields())) {
                $obj->delData();
                return;
            }

            $groupList = self::find()->select($obj->groupDbFields())
                ->where($condition, $params)
                ->groupBy($obj->groupDbFields())
                ->asArray()
                ->all();

            if (!empty($groupList)){
                foreach ($groupList as $item) {
                    $group = '';
                    foreach ($obj->groupDbFields() as $field) {
                        $group .= $item[$field] . $delimiter;
                    }
                    $obj->setGroup(rtrim($group, $delimiter));

                    $obj->delData();
                }
            }
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
        }

    }

    /**
     * 模型保存之后
     * @param $insert
     * @param $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        // 触发清除缓存
        if ($insert){ //要新数据是因为save的update方法，走的是updateAll
            self::clearCache($this);
        }
    }

    /**
     * 模型删除之后
     */
    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        
        // 触发清除缓存
        self::clearCache($this);
    }

    /**
     * @param $counters
     * @param string $condition
     * @param array $params
     * @return int
     */
    public static function updateAllCounters($counters, $condition = '', $params = [])
    {
        $active = parent::updateAllCounters($counters, $condition, $params); // TODO: Change the autogenerated stub

        if ($active) {// 有数据响应，触发清除缓存
            self::batchClearCache($condition, $params);
        }

        return $active;
    }

    /**
     * @param $attributes
     * @param string $condition
     * @param array $params
     * @return int
     */
    public static function updateAll($attributes, $condition = '', $params = [])
    {
        $active = parent::updateAll($attributes, $condition, $params); // TODO: Change the autogenerated stub

        if ($active) {// 有数据响应，触发清除缓存
            self::batchClearCache($condition, $params);
        }

        return $active;
    }

    /**
     * @param null $condition
     * @param array $params
     * @return int
     */
    public static function deleteAll($condition = null, $params = [])
    {
        $active = parent::deleteAll($condition, $params); // TODO: Change the autogenerated stub

        if ($active) {// 有数据响应，触发清除缓存
            self::batchClearCache($condition, $params);
        }

        return $active;
    }
}