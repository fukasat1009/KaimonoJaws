<template>
    <div class="order_items__container">
		<div class="cartItems">
			<div class="cartItems__items" v-for="item in dataItems" :key="item.id">
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
					<button type="button"  v-on:click="deleteItem(item.id,authId)">削除</button>
					<button type="button"  v-on:click="getToken(item.id,authId)">削除テスト</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    export default {
        props: {
            orderItems: Array,
			authId: Number,
        },
		data: function() {
			return {
				dataItems: this.orderItems
			}
		},
		methods: {
            deleteItem(item,auth) {
				axios.post('/api/orderDetail/remove', {
					item: item,
					auth_id: auth
					}).then((res)=>{
						this.dataItems = res.cartList
				})
            },
			getToken(item,auth) {
				axios.post('/api/token', {
					auth_id: auth
				}).then((res)=>{
					if(res.data == 1){
						this.deleteItem(item,auth)
					} else {
						alert("不正なアクセスです。");
					}
				})
			}

        }
    }
</script>