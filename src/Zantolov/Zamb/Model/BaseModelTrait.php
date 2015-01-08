<?php

namespace Zantolov\Zamb\Model;

trait BaseModelTrait
{

    /**
     * Dynamically calls related saving methods based on keys in related arrays (eg. rolesSave())
     * @param $relatedValues Array of related values where key is related getter method name (eg. roles for roles())
     */
    public function saveRelated($relatedValues)
    {
        foreach ($relatedValues as $relatedMethodGetter => $relatedIds) {
            $methodName = $relatedMethodGetter . 'Save';
            if (method_exists($this, $methodName)) {

                if (is_null($relatedIds)) {
                    $relatedIds = array();
                }

                $this->$methodName($relatedIds);
                $this->getRelatedIds($relatedMethodGetter);
            } else {
                \Log::error('Related save method not defined: ' . $methodName);
            }
        }
    }

    /**
     * Dynamically lazy loads related Ids for certain related model key
     * @param $relatedModel
     * @return mixed
     */
    public function getRelatedIds($relatedMethodGetter)
    {
        if (!property_exists($this, 'relatedIds')) {
            \Log::error('$relatedIds doesn\'t exists');
        }

        if (empty($this->relatedIds[$relatedMethodGetter])) {
            $methodName = $relatedMethodGetter . 'LoadIds';
            if (method_exists($this, $methodName)) {
                $this->$methodName();
            } else {
                \Log::error('Related get method not defined: ' . $methodName);
            }
        }

        return $this->relatedIds[$relatedMethodGetter];
    }
}