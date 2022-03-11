<template>
    <div class="delivery_destination">
        <div class="delivery_destination__container">
            <ul>
                <li v-for="address in deliveryDestinations" :key="address.id">
                    <input type="radio" v-model="select" :id="address.id" :value="address.id" name="address_id">
                    〒{{ address.postal_code }}
                    {{ address.prefecture }}
                    {{address.city}}
                    {{ address.block }}
                    {{ address.building }}
                    {{ address.room_number }}
                    TEL:{{ address.phone_number }}
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                //配列のidの最小値を初期値にセット
                select: this.deliveryDestinations.reduce((a,b)=>a.id<b.id?a:b).id,
            }
        },
        props: {
            deliveryDestinations: Array,
        }
    }
</script>