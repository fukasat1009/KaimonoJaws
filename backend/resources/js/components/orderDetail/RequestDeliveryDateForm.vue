<template>
    <div class="order-items__req-date">
        <datepicker
            :value="defaultdate"
            :format="this.DatePickerFormat"
            :name="name"
            :language="ja"
            input-class="form-control bg-white"
            :highlighted="highlighted"
            :disabled-dates="disabledDates"
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
        var date = new Date();
        var newdate = date.setDate(date.getDate() + 1);

        return {
            DatePickerFormat: "yyyy/MM/dd",
            ja: ja,
            highlighted: {
                days: [6, 0]
            },
            disabledDates: {
                to: new Date(newdate),
            }
        };
    }
};
</script>