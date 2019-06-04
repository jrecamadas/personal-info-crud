<template>
    <div class="portfolio-container">
        <p class="head">
            <span class="title" v-if="position">{{position}}</span>
            <span class="title" v-else>{{description}}</span>
            <span class="date">
                {{startDate}}
                <span v-if="startDate != '' && endDate != ''">-</span>
                {{endDate}}
            </span>
        </p>
        <p v-if="name">{{name}}</p>
        <p class="description" v-if="position">{{description}}</p>
    </div>
</template>
<style lang="scss" scoped>
.portfolio-container {
    padding-left: 30px;
    font-size: 16px;
    .head {
        .title {
            font-size: 18px;
            color: #58863e;
            margin-right: 30px;
        }
        .date {
            font-size: 14px;
            display: block;
        }
    }
}
</style>

<script>
export default {
    props: {
        name: {
            type: String,
            required: false,
            default: function() {
                return "";
            }
        },
        startDate: {
            type: [String, Number],
            required: false,
            default: function() {
                return "";
            }
        },
        endDate: {
            type: [String, Number],
            required: false,
            default: function() {
                return "";
            }
        },
        description: {
            type: String,
            required: false,
            default: function() {
                return "";
            }
        },
        position: {
            type: String,
            required: false,
            default: function() {
                return "";
            }
        }
    }
};
</script>
