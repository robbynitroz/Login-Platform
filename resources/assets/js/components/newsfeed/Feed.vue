<template>
    <div
            @mouseenter='updateHoverState(false)'
            @mouseleave="updateHoverState(true)"
    >
        <b-card
                :img-src="image"
                img-fluid
                :img-alt="title"
                img-top>
            <div class="overlay"></div>
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
                front:true,
            }
        },

        methods: {
            updateHoverState(isHover) {
                this.front = isHover;
            },

            openLink(){
                window.open(this.link, '_blank');
            }

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
        transition: all 1s ease-in-out;
        width: 100%;
    }

    .card:hover{
        transform: rotateY(180deg);
    }


    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        transition: background 0.5s ease;
    }

    .card:hover .overlay {
        display: block;
        background: rgb(255, 255, 255);
    }


    .secondary {
        position: absolute;
        width: 100%;
        height: 100%;
        left:0;
        top: 0;
        text-align: center;
        display: none;
        transition: opacity .8s ease;
        transform: rotateY(180deg);
    }

    .card:hover .secondary {
        display: block;
        text-align: center;
        vertical-align: middle;
    }


</style>