<template>
    <div id="f1_container">
        <b-card
                :img-src="image"
                img-fluid
                :img-alt="title"
                img-top>
            <div :class="cssClass" class="overlay"></div>
            <span v-html="title"></span>
            <div class="secondary">
                <div class="center-content">
                    <span v-html="text"></span>
                    <b-button @click="openLink()" v-if="button" size="lg" variant="primary">{{ button }}</b-button>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>

    export default {
        name: "feed",
        data(){
            return {
                cssClass:'',
            }
        },

        methods: {

        },

        mounted(){

        },

        props:[
            'image',
            'title',
            'text',
            'button',
            'link',
        ]
    }
</script>

<style scoped>
    #f1_container {
        perspective: 1000;
    }

    .center-content {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        flex-direction: column;
    }

    .card {
        height: 100%;
        transform-style: preserve-3d;
        transition: 1s ease-in-out;
        width: 100%;
    }

    .card:hover{
        transform: rotateY(180deg);
    }

    button{
        background: #2087b0 !important;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgb(211, 208, 209);
        opacity: 0;
    }

    .card:hover .overlay {
        display: block;
        opacity: 1;
        transform: rotateY(180deg);
    }


    .secondary {
        position: absolute;
        width: 100%;
        height: 100%;
        left:0;
        top: 0;
        text-align: center;
        display: none;
        transform: rotateY(180deg);
    }

    .card:hover .secondary {
        display: block;
        text-align: center;
        vertical-align: middle;
    }



</style>