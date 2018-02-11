<template>
    <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
          <b>  {{ welcome }} {{ name }} ! </b>
            <img :src="image" class="img-avatar" alt="admin@bootstrapmaster.com">
        </template>
        <b-dropdown-header tag="div" class="text-center"><strong>Settings</strong></b-dropdown-header>
        <b-dropdown-item :to="{name:'My account'}"><i class="fa fa-user"></i> Profile</b-dropdown-item>
        <b-dropdown-item @click="logout()"><i class="fa fa-lock"></i> Logout</b-dropdown-item>
    </b-nav-item-dropdown>
</template>
<script>
    export default {
        name: 'header-dropdown',
        data(){
            return {
                name:'',
                image:'',
                welcomeModes:[
                    'Hi',
                    'Hey',
                    'Hello',
                    'Welcome',
                    'Yo',
                    'Ahoy',
                    'Howdy',
                    'Aloha',
                ]
            }
        },

        mounted()
        {
          this.getUserData();
        },

        computed:{
          welcome(){
              return this.welcomeModes[Math.floor(Math.random() * this.welcomeModes.length)];
            }
        },

        methods:{

            getUserData(){
                axios.get('/user').then(response=>{
                        this.image = response.data.picture;
                       this.name= response.data.name;
                }
                ).catch(

                )
            },

          logout()
          {  axios.post(
                  '/logout', {}
              ).then(response=>{
                  window.location.replace("/login");
              }).catch(e=>{
                  alert('Something went wrong')
              });
          }
        }
    }
</script>

