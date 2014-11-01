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
                $this->$methodName($relatedIds);
                $this->getRelatedIds($relatedMethodGetter);
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
        if (empty($this->relatedIds[$relatedMethodGetter])) {
            $methodName = $relatedMethodGetter . 'LoadIds';
            if (method_exists($this, $methodName)) {
                $this->$methodName();
            }
        }
        return $this->relatedIds[$relatedMethodGetter];
    }
}