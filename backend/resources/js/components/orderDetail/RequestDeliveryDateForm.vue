<template>
    <div class="order-items__req-date">
        <!-- 配送希望日：<input name="req_delivery_date" type="date" /> -->
        <datepicker
            :value="defaultdate"
            :format="this.DatePickerFormat"
            :name="name"
            :language="ja"
            input-class="form-control bg-white"
            :highlighted="highlighted"
        >
        </datepicker>
    </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import { ja } from "vuejs-datepicker/dist/locale";

export default {

    components: {
        Datepicker
    },
    props: {
        name: {
            type: String,
            required: true
        },
        defaultdate: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            DatePickerFormat: "yyyy/MM/dd",
            ja: ja,
            highlighted: {
                days: [6, 0]
            }
        };
    }
};
</script>