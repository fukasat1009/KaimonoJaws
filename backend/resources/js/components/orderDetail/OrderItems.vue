<template>
    <div class="order_items__container">
		<div class="cartItems">
			<div class="cartItems__items" v-for="item in orderItems" :key="item.id">
				<div class="cartItems__items--name">
					<p>商品名：{{ item.product_name }}</p>
				</div>
				<div class="cartItems__items--quantity">
					<p>注文数：{{ item.pivot.quantity }}</p>
				</div>
				<div class="cartItems__items--price">
					<p>単価：¥{{ item.price }}</p>
				</div>
				<div class="cartItems__items--total-price">
					<p>合計金額：¥{{ item.price * item.pivot.quantity }}</p>
				</div>
				<div class="cartItems__items__delete">
					<button type="button"  v-on:click="deleteItem(item.id)">削除</button>
					<!-- <form action="{{ route('removeProduct') }}" method="post"> -->
						<!-- {{ csrf_field() }}
						<input name="remove_id" value="{{ $product['product_id'] }}" type="hidden"> -->
						<!-- 削除に関してはJavascriptで実装予定-->
						<!-- <button id="">削除</button> -->
					<!-- </form> -->
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    export default {
        // data: function() {
        //     return {
        //         //配列のidの最小値を初期値にセット
        //         select: this.deliveryDestinations.reduce((a,b)=>a.id<b.id?a:b).id,
        //     }
        // },
        props: {
            orderItems: Array,
        },
		methods: {
            deleteItem(item) {
				console.log('-----------');
				console.log(item);
				axios.post('/api/orderDetail/remove', {
					item: item
					}).then((res)=>{
					alert('削除成功');
				})
            }
        }
    }
</script>