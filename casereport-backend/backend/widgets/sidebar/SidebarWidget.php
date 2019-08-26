<?php
namespace backend\widgets\sidebar;

/**
 * 后台siderbar插件
 */
use Yii;
use yii\base\Widget;
use yii\widgets\Menu;

class SidebarWidget extends Menu
{    
    public $submenuTemplate = "\n<ul class=\"children\">\n{items}\n</ul>\n";
    
    public $options = ['class'=>'nav nav-pills nav-stacked nav-quirk'];
    
    public $activateParents = true;
    
    public function init()
    {
        $this->items = [
            ['label' =>'<i class="fa fa-dashboard"></i><span>Dashboard</span>','url'=>['site/index']],
            ['label' =>'<a href=""><i class="fa fa-th-list"></i><span>Case Management</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
                    ['label'=>'Case Management','url'=>['post/index'],'items'=>[
                        ['label'=>'创建文章','url'=>['post/create'],'visible'=>false],
                        ['label'=>'更新文章','url'=>['post/update'],'visible'=>false],
                        ]                       
                    ],
                    ['label'=>'Case Category','url'=>['cat/index'],'items'=>[
                        ['label'=>'创建文章','url'=>['cat/create'],'visible'=>false],
                        ['label'=>'更新文章','url'=>['cat/update'],'visible'=>false],
                        ]                        
                    ],
                    ['label'=>'Location Tag','url'=>['tag/index']],
                ]
            ],
            ['label' =>'<a href=""><i class="fa fa-user"></i><span>Lea Management</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
                    ['label'=>'LEA Management','url'=>['user/index']],
                ]
            ],
        ];
    }
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }

            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
        }

        return array_values($items);
    }
}