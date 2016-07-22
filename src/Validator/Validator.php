<?php
namespace Andy\Validator;

/**
 *
 */
class Validator
{
    protected $data;

    protected $rules;

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function validate()
    {

    }
    //TODO
    //1、分析rule的方法，并存储到一个属性里
    //2、分析是否是默认的判定规则，如果是，则执行相关校验方法，不是则根据对应的类或者callback去处理
    //3、定义interface，作为过滤器统一接口
}
