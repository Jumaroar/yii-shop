<?php
	$this->renderPartial('/order/waypoint', array('point' => 4));
	
	$this->breadcrumbs=array(
		Shop::t('Order')=>array('index'),
		Shop::t('New Order'),
	);
?>

<?php 
	Shop::renderFlash();
	$this->renderPartial('application.modules.shop.views.shoppingCart.view'); 

if(Shop::getCartContent() == array())
	return false;

// If the customer is not passed over to the view, we assume the user is 
// logged in and we fetch the customer data from the customer table
if(!isset($customer))
	$customer = Shop::getCustomer();

$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => $customer,
				'hideAddress' => true));

echo '<div class="summary_billing_address">';
$this->renderPartial('application.modules.shop.views.paymentMethod.view', array(
			'model' => PaymentMethod::model()->findByPk(Yii::app()->user->getState('payment_method'))));
echo '</div>';

echo '<div class="summary_delivery_address">';
$this->renderPartial('application.modules.shop.views.shippingMethod.view', array(
			'model' => ShippingMethod::model()->findByPk(Yii::app()->user->getState('shipping_method'))));
echo '</div>';



echo '<br />';
echo CHtml::beginForm(array('//shop/order/confirm'));
$this->renderPartial(Shop::module()->termsView);
echo '<br />';
echo '<br />';

	?>

	<div class="row buttons">
	<?php echo CHtml::link(Shop::t('Edit customer Information'), array(
				'//shop/customer/update', 'order' => true)); ?> &nbsp;
	<?php echo CHtml::link(Shop::t('Edit payment method'), array(
				'//shop/paymentMethod/choose', 'order' => true)); ?> &nbsp;
	<?php echo CHtml::link(Shop::t('Edit shipping method'), array(
				'//shop/shippingMethod/choose', 'order' => true)); ?> &nbsp;


	<?php echo CHtml::submitButton(Shop::t('Confirm Order'), array(
				'//shop/order/confirm')); ?>

<?php echo CHtml::endForm(); ?>
</div>