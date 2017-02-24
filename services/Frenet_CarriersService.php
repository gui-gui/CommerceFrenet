<?php

namespace Craft;

class Frenet_CarriersService extends Frenet_BaseService
{
    
    /**
     * @param int $id
     *
     * @return Frenet_CarrierModel|null
     */
    public function getCarrierById($id)
    {
        $result = Frenet_CarrierRecord::model()->findById($id);

        if ($result)
        {
            return Frenet_CarrierModel::populateModel($result);
        }
        return null;
    }
    
    public function getAllCarriers($criteria = []) 
    {
        $carrierRecords = Frenet_CarrierRecord::model()->findAll($criteria);

        return Frenet_CarrierModel::populateModels($carrierRecords);
    }

    public function saveCarrier(Frenet_CarrierModel $model) 
    {
        if($model->id)
        {
            $record = Frenet_CarrierRecord::model()->findById($model->id);
            if (!$record->id)
            {
                throw new Exception(Craft::t('No carrier exists with the ID “{id}”',
                    ['id' => $model->id]));
            }
        }
        else
        {
            $record = new Frenet_CarrierRecord();
        }

        $record->name = $model->name;
        $record->handle = $model->carrierCode . '-' . $model->serviceCode;
        $record->serviceCode = $model->serviceCode;
        $record->carrierCode = $model->carrierCode;
        $record->serviceDescription = $model->serviceDescription;
        $record->extraShippingDays = $model->extraShippingDays;
        $record->methodId = $model->methodId;

        if($record->methodId === null) 
        {
            return false;
        }

        $record->validate();
        $model->addErrors($record->getErrors());
        
        //validating shipping methods ids
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('id', [$model->methodId]);
        $exist = Commerce_ShippingMethodRecord::model()->exists($criteria);
        $hasMethod = (boolean)is_null($model->methodId);

        if (!$exist && $hasMethod)
        {
            $model->addError('method',
                'The shipping methods does not exist in the system.');
        }

        //saving
        if (!$model->hasErrors())
        {
            try
            {
                // Save it!
                $record->save(false);

                // Now that we have a calendar ID, save it on the model
                $model->id = $record->id;
            }
            catch (\Exception $e)
            {
                throw $e;
            }

            return true;
        }
        else
        {
            return false;
        }

        
    }


    /**
    * @param int
    *
    * @return bool
    */
    public function deleteCarrierById($id)
    {
        Frenet_CarrierRecord::model()->deleteByPk($id);
        return true;
    }

}