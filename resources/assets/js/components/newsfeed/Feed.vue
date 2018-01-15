<template>
    <div id="container">

        <figure class="card card-flip">
            <div class="card">
                <img class="card-img img-fluid" :src="image" alt="">
                <span class="main-text" v-html="title"></span>
            </div>
            <div class="card gry">
                <div class="card-body d-flex justify-content-center align-items-center">
                     <div class="button" v-html="text"></div>
                    <b-button class="button" @click="openLink()" v-if="button" size="lg" variant="primary">{{ button }}</b-button>
                </div>


            </div>
        </figure>

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
            openLink(){
                window.open(this.link,'_blank');
            }
        },

        computed:{

            linkButton(){

                if(this.button){
                    return this.text + this.button
                }

                return this.text
            },
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

<style scoped lang="scss">
    #container {
        perspective: 1000;
    }

    .button{
        display: block;
        float: none;
    }

    .main-text{
        margin: 10px;
    }

    .card-flip {

        background: none;
        border: none;
        padding: 0;

    .card {
        backface-visibility: hidden;
        transition: transform 300ms;
        transition-timing-function: linear;
        width: 100%;
        height: 100%;
        margin: 0;
    }

    .card:first-of-type {
        tranform: rotateY(0deg);
    }

    .card:last-of-type {
        transform: rotateY(180deg);
    // Put this in face with the larger content
    position: absolute;
        top: 0;
        display: flex;
    }

    &:hover {
    .card:first-of-type  {
        transform: rotateY(-180deg);
    }
    .card:last-of-type {
        transform: rotateY(0deg);
    }
    }

    }

    .gry{
        background: rgb(211, 208, 209);
    }

    button{
        background: #2087b0 !important;
        cursor: pointer;
        display: block;
        overflow: hidden;
        z-index: 999;
        border: none;
        position: absolute;
        bottom: 30%;
    }


</style>