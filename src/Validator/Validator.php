<?php
namespace Andy\Validator;

use Closure;

/**
 *
 */
class Validator
{
    protected $data;

    protected $rules;

    protected $expectedRules;

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public static function validate(array $data, array $rules)
    {
        $validator = new self($data, $rules);
        return $validator->doValidate();
    }

    protected function doValidate()
    {
        $this->analysisRules();
        $result = [];
        foreach ($this->expectedRules as $key => $ruleArray) {
            $result[$key] = true;
            foreach ($ruleArray as $rule) {
                if ($rule['filter'] instanceof Closure) {
                    $result[$key] = $result[$key] && $rule['filter']($this->data[$key]);
                } else {
                    $filter = $rule['filter'];
                    $params = $rule['params'];
                    $result[$key] = $result[$key] && $this->$filter($this->data, $key, $params);
                }
            }
        }
        return $result;
    }

    protected function analysisRules()
    {
        $this->expectedRules = [];
        foreach ($this->rules as $key => $rule) {
            if ($rule instanceof Closure) {
                $this->expectedRules[$key][] = [
                    'filter' => $rule
                ];
            } else {
                $ruleItems = explode('|', $rule);
                foreach ($ruleItems as $item) {
                    if (empty($item)) {
                        continue;
                    }
                    $detail = explode(':', $item);
                    $this->expectedRules[$key][] = [
                        'filter' => $detail[0],
                        'params' => empty($detail[1]) ? [] : explode(',', $detail[1])
                    ];
                }
            }
        }
    }

    protected function required($data, $key, $params = null)
    {
        if (!array_key_exists($key, $data)) {
            return false;
        }
        if (empty($data[$key])) {
            return false;
        }
        return true;
    }

    protected function length($data, $key, $params)
    {
        $count = count($params);
        if ($count === 1) {
            return strlen($data[$key]) === intval($params[0]);
        } elseif ($count === 2) {
            if (strlen($data[$key]) >= $params[0] && strlen($data[$key]) < $params[1]) {
                return true;
            }
        }
        return false;
    }
}
