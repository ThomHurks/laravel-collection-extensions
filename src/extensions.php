<?php

use Illuminate\Support\Collection;

if (! Collection::hasMacro('groupByMultiple')) {
    /*
     * Group an associative array by multiple fields or callbacks.
     *
     * @param  string|array  $groupBy
     * @param  bool  $preserveKeys
     * @return Collection
     */
    Collection::macro('groupByMultiple', function ($groupBy, $preserveKeys = false): Collection {
        if (! is_array($groupBy)) {
            $groupBy = [$groupBy];
        }

        $groupKeyRetrievers = [];
        foreach ($groupBy as $currentGroupBy) {
            $groupKeyRetrievers[] = $this->valueRetriever($currentGroupBy);
        }

        $results = [];

        foreach ($this->items as $key => $value) {
            $currentLevel = [&$results];
            $nextLevel = [];
            foreach ($groupKeyRetrievers as $currentGroupBy) {
                $groupKeys = $currentGroupBy($value);
                if (! is_array($groupKeys)) {
                    $groupKeys = [$groupKeys];
                }
                foreach ($groupKeys as $groupKey) {
                    foreach ($currentLevel as &$subGroup) {
                        if (! array_key_exists($groupKey, $subGroup)) {
                            $subGroup[$groupKey] = [];
                        }
                        $nextLevel[] = &$subGroup[$groupKey];
                    }
                }
                $currentLevel = $nextLevel;
                $nextLevel = [];
            }
            if ($preserveKeys && ! is_null($key)) {
                foreach ($currentLevel as &$lastLevel) {
                    $lastLevel[$key] = $value;
                }
            } else {
                foreach ($currentLevel as &$lastLevel) {
                    $lastLevel[] = $value;
                }
            }
        }

        $toNestedCollection = function (&$array) use (&$toNestedCollection) {
            if (is_array($array)) {
                foreach ($array as &$subArray) {
                    $subArray = $toNestedCollection($subArray);
                }

                return new static($array);
            } else {
                return $array;
            }
        };

        return $toNestedCollection($results);
    });
}
