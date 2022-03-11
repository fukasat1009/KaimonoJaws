<template>
    <div>
        <input type="radio" id="0" name="payment" value="credit" v-model="payment">クレジット支払い
        <input type="radio" id="1" name="payment" value="cash" v-model="payment">代引き
        {{ data }}
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                payment: 'credit',
            }
        },
    }
</script>
