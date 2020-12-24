<template>
    <div v-if="user" class="text-center">

        <navbar></navbar>

<b-container style="text-align:left; position: absolute; top: 0; left:0; margin-top: 80px; margin-left: 25px;">
      <div>
        <b-button @click="backbutton" class="button button-close" variant="danger">Back</b-button>
      </div>
    </b-container> 
    <br/><br/>
        <form id="form" @submit.prevent="profileUpload" methode="POST">

            <div v-if="preview == null">
                <img id="img" class="center" :src="src" style="width: 100px; height:100px; border-radius:50%; ">
            </div>
            <div v-if="preview">
                <img id="img" class="center" :src="preview" style="width: 100px; height:100px; border-radius:50%; ">
            </div>
<br/>
            <div style="width: 400px;" class="input-group mx-auto" id="inputs">
            <div class="custom-file">
                <input type="file"  @change="imageSelected" name="fileToUpload" class="custom-file-input" id="inputGroupFile04">
                <label class="custom-file-label" for="inputGroupFile05">Choose</label>
            </div>
            </div>
            <br/>
                <button class="btn btn-outline-secondary" id="upload" value="Upload Image" name="submit" type="submit">Upload</button>

                <br/>

        </form>

        <b-container style="text-align:right; position: absolute; bottom: 0; right:0; margin-bottom: 80px; margin-right: 25px;">
            <div>
                <alert></alert>
            </div>
        </b-container>

        <div class="text-center">
        <footer style="height: 50px; background-color: #343a40; position: absolute; left: 0; right: 0; bottom: 0;">
            <p style="padding-top: 13px; color: white">&copy; Copyright 2020 | PP2 - Group 6</p>
        </footer>
    </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            user:null,
            avatar:null,
            preview:null,
            src:"/uploads/avatars/",
            
        }
    },
    mounted() {
        axios.get('/api/user').then((res)=>{

            this.user = res.data;

            this.src= this.src+res.data.avatar;

        
        });

    },
    methods:{
        
        //show image of selected image
        imageSelected(e){

            this.avatar = e.target.files[0];

            let reader = new FileReader();

            reader.readAsDataURL(this.avatar);
            reader.onload = e =>{

            this.preview = e.target.result;

            };


        },

        // upload selected image
        profileUpload(){

            let data = new FormData();

            data.append('image', this.avatar);

            axios.post('/api/uploadAvatar', data).then(()=>{

            }).catch(()=>{

            })

            this.$router.push({ name: "dashboard" });
        },
         backbutton() {
         this.$router.push({ name: "dashboard" });
        },
  

    
        
    }    
    
}

</script>

<style scoped>

</style>