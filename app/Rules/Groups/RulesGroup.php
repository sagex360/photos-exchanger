<?php


namespace App\Rules\Groups;


abstract class RulesGroup
{
    /** @var array */
    private $toMerge = [];

    /**
     * @param array $otherRules
     * @return RulesGroup
     */
    public function merge(array $otherRules): self
    {
        $this->toMerge = $otherRules;

        return $this;
    }

    public function get()
    {
        $rules = array_merge($this->rules(), $this->toMerge);

        $this->flush();

        return $rules;
    }

    protected function flush()
    {
        $this->toMerge = [];
    }

    protected abstract function rules();
}
