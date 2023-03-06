<?php

namespace Farhanisty\Mariana;

class AssemblerEntity
{
    private $data;
    private $parent;
    private $child;
    private $manipulateChild;
    private $installRule;

    public function __construct(array $data, $parent, $child)
    {
        $this->data = $data;
        $this->parent = $parent;
        $this->child = $child;
    }

    public function setManipulationChild(callable $manipulateChild)
    {
        $this->manipulateChild = $manipulateChild;
    }

    public function setInstallRule(callable $installRule)
    {
        $this->installRule = $installRule;
    }

    public function build()
    {
        $idParent = [];
        $idChild = [];

        $result = [];

        foreach ($this->data as $d) {
            if (!in_array($d["id"], $idParent)) {
                $parent = $this->parent::arrayToObject($d);
                $result[] = $parent;

                $idParent[] = $d["id"];
            }

            if ($this->manipulateChild) {
                $child = $this->child::arrayToObject(
                    call_user_func_array($this->manipulateChild, [$d])
                );
            } else {
                $child = $this->child::arrayToObject($d);
            }

            $idChild[$d["id"]][] = $child;
        }

        foreach ($result as $parent) {
            call_user_func_array($this->installRule, [$parent, $idChild]);
        }

        return $result;
    }
}
