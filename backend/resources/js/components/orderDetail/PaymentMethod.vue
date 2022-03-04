<template>
    <div>
        <input type="radio" id="credit" name="" value="0" v-model="payment">クレジット支払い
        <input type="radio" id="cash" name="" value="1" v-model="payment">代引き
        <p>{{test}}</p>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                payment: 'credit',
                props:['test']
            }
        }
    }
</script>
