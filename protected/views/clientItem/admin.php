<?php
$this->breadcrumbs=array(
	'Customer'=>array('client/admin'),
        'List',
);?>
<div class="span12" style="float: none;margin-left: auto; margin-right: auto;">
<div>
    <div class="span7">
        <div class="message" style="display:none">
            <div class="alert in alert-block fade alert-success">Transaction Failed !</div>
        </div>

        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
        
        <div class="grid-view" id="grid_cart">  
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'id'=>'sale-item-form',
                    'enableAjaxValidation'=>false,
                    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
            )); ?>
            <?php
            if (isset($warning))
            {
                echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, $warning);
            }
            ?>
            <table class="table table-hover table-condensed">
                <thead>
                    <tr><th><?php echo Yii::t('model','model.saleitem.name'); ?></th>
                        <th><?php echo Yii::t('model','model.saleitem.price'); ?></th>
                        <th><?php echo Yii::t('model','model.saleitem.quantity'); ?></th>
                        <th><?php echo Yii::t('model','model.saleitem.discount_amount'); ?></th>
                        <th><?php echo Yii::t('model','model.saleitem.total'); ?></th>
                    </tr>
                </thead>
                <tbody id="cart_contents">
                    <?php foreach(array_reverse($items,true) as $id=>$item): ?>
                        <?php
                            if (substr($item['discount'],0,1)=='$')
                            {
                                $total_item=number_format($item['price']*$item['quantity']-substr($item['discount'],1),Yii::app()->shoppingCart->getDecimalPlace());
                            }    
                            else  
                            {  
                                $total_item=number_format(($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100),Yii::app()->shoppingCart->getDecimalPlace());
                            } 
                            $item_id=$item['item_id'];
                            $cur_item_info= Item::model()->findbyPk($item_id);
                            $qty_in_stock=$cur_item_info->quantity;
                            $cur_item_unit= ItemUnitQuantity::model()->findbyPk($item_id);
                            $unit_name='';
                            if ($cur_item_unit)
                            {
                                $item_unit=ItemUnit::model()->findbyPk($cur_item_unit->unit_id);
                                $unit_name=$item_unit->unit_name;
                            }
                        ?>
                            <tr>
                                <td> 
                                    <?php echo $item['name']; ?><br/>
                                    <span class="text-info"><?php echo $qty_in_stock . ' ' . $unit_name .  ' ' . Yii::t('app','in stock') ?> </span>
                                </td>
                                <td><?php echo $form->textField($model,"[$item_id]price",array('value'=>$item['price'],'class'=>'input-small numeric','id'=>"price_$item_id",'placeholder'=>'Price','data-id'=>"$item_id",'maxlength'=>50,'onkeypress'=>'return isNumberKey(event)')); ?></td>
                                <td>
                                    <?php echo $form->textField($model,"[$item_id]quantity",array('value'=>$item['quantity'],'class'=>'input-small numeric','id'=>"quantity_$item_id",'placeholder'=>'Quantity','data-id'=>"$item_id",'maxlength'=>50,'onkeypress'=>'return isNumberKey(event)')); ?>
                                </td>
                                <td><?php //echo $form->dropDownList($model, 'discount',array('%', '$'),array('class'=>'input-mini')); ?>
                                    <?php echo $form->textField($model,"[$item_id]discount",array('value'=>$item['discount'],'class'=>'input-small','id'=>"discount_$item_id",'placeholder'=>'Discount','data-id'=>"$item_id",'maxlength'=>50)); ?></td>
                                <td><?php echo $total_item; ?>
                                <td><?php echo TbHtml::linkButton('',array(
                                        //'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                                        'size'=>TbHtml::BUTTON_SIZE_MINI,
                                        'icon'=>'trash',
                                        'url'=>array('DeleteItem','item_id'=>$item_id),
                                        'class'=>'delete-item',
                                        'title' => Yii::t( 'app', 'Remove' ),
                                    )); ?>
                                </td>    
                            </tr>
                        <?php //$this->endWidget(); ?>  <!--/endformWidget-->     
                    <?php endforeach; ?> <!--/endforeach-->
                   
                </tbody>
            </table>
            <?php $this->endWidget(); ?>  <!--/endformWidget-->     
            
            <?php
            if (empty($items))
                echo Yii::t('app','There are no items in the cart');
            
            ?> 
            
        </div> <!--/endgridcartdiv-->
          
    </div> <!--/span9-->
    
    <div class="span4">
          
        <div class="sidebar-nav" id="client_cart">
            <?php 
            if(isset($customer)) 
            {
                $this->widget('yiiwheels.widgets.box.WhBox', array(
                       'title' => Yii::t('app','form.sale.client_title'),
                       'headerIcon' => 'icon-user',
                       'content' => $this->renderPartial('_client_selected',array('model'=>$model,'customer'=>$customer,'customer_mobile_no'=>$customer_mobile_no),true),
                 ));
            }else 
            { 
                $this->widget('yiiwheels.widgets.box.WhBox', array(
                       'title' => Yii::t('app','form.sale.client_title'),
                       'headerIcon' => 'icon-user',
                       'content' => $this->renderPartial('_client',array('model'=>$model),true)
                 ));
            }
            ?>
         </div>
          
          <div class="sidebar-nav" id="task_cart">
                <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
                       'title' => Yii::t('app','Total Quantity') . ' : ' . $count_item,
                       'headerIcon' => 'icon-tasks',
               ));?>   
                   <?php if ( $count_item<>0 ) { ?>
                       <div align="right">       
                       <?php echo TbHtml::linkButton(Yii::t('app','Cancel'),array(
                               'color'=>TbHtml::BUTTON_COLOR_DANGER,
                               'size'=>TbHtml::BUTTON_SIZE_SMALL,
                               'icon'=>'remove',
                               'url'=>Yii::app()->createUrl('ClientItem/CancelSale/'),
                               'class'=>'cancel-sale',
                               'title' => Yii::t( 'app', 'Cancel' ),
                       )); ?>

                       <?php echo TbHtml::linkButton(Yii::t('app','Done'),array(
                               'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                               'size'=>TbHtml::BUTTON_SIZE_SMALL,
                               'icon'=>'off white',
                               'url'=>Yii::app()->createUrl('ClientItem/CompleteSale/'),
                               'class'=>'complete-tran',
                               'title' => Yii::t( 'app', 'Complete' ),
                        )); ?>         
                       </div>
                     <?php } ?>
                <?php $this->endWidget(); ?> <!--/endtaskwidget-->
          </div>
    </div> <!--/span3-->
    
 </div>

</div>

<div class="waiting"><!-- Place at bottom of page --></div>
