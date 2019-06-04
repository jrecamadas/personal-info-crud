<?php

namespace App\Traits;

use App\Criterias\ClientFeedback\SearchSequenceConflict;

/**
 * SortedRows Trait
 *
 * Perform linear sorting
 *
 * @package App\Traits
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */
trait SortedRows
{
    abstract protected function applyIDFilter($data);

    public function create(array $data)
    {
        if (!in_array('displaySequence', array_keys($data))) {
            $data['displaySequence'] = $this->createSequence($data);
        }

        $model = parent::create($data);

        $this->updateSequence($model);

        return $model;
    }

    protected function createSequence($data)
    {
        $model = $this->applyIDFilter($data);

        $items = $model->orderBy('display_sequence', 'desc')->get();

        if ($items->isEmpty()) {
            return 1;
        } else {
            return $items[0]->display_sequence + 1;
        }
    }

    public function update(array $data, $id)
    {
        $result = parent::update($data, $id);

        $this->updateSequence($result);

        return $result;
    }

    public function updateSequence($record)
    {
        $model = $this->applyIDFilter($record);

        $seq = $seq = new SearchSequenceConflict($record->displaySequence);

        $model = $seq->apply($model, $this);

        if ($model->get()->count() > 1) {
            $model = $this->applyIDFilter($record);
            $items = $model->orderBy('display_sequence', 'asc')->get();

            $index = 1;

            foreach ($items as $item) {
                if ($item->id == $record->id) {
                    if ($index != $record->displaySequence) {
                        continue;
                    }
                } elseif ($index == $record->displaySequence) {
                    if ($item->id != $record->id) {
                        $index++;
                    }
                }

                $item->displaySequence = $index;
                $item->save();
                $index++;
            }
        }
    }
}
