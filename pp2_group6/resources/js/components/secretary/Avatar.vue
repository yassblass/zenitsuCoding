<template>
    <div v-if="user">

        <navbar></navbar>
        <form @submit.prevent="profileUpload" methode="POST">

            <div v-if="preview == null">
                <img id="img" class="center" :src="src" style="width: 100px; height:100px; border-radius:50%; ">
            </div>
            <div v-if="preview">
                <img id="img" class="center" :src="preview" style="width: 100px; height:100px; border-radius:50%; ">
            </div>

            <div class="input-group" id="inputs">
            <div class="custom-file">
                <input type="file"  @change="imageSelected" name="fileToUpload" class="custom-file-input" id="inputGroupFile04">
                <label class="custom-file-label" for="inputGroupFile05">Choose</label>
            </div>
            </div>
                <button class="btn btn-outline-secondary" id="upload" value="Upload Image" name="submit" type="submit">Upload</button>

<!--             
            <input type="file" @change="imageSelected" name="fileToUpload" class="custom-file-input" id="inputGroupFile02" >
             <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
            <button type="submit" value="Upload Image" name="submit">Upload image</button> -->
        </form>

   <div id="button-alert">
      <alert></alert>
    </div>
    <div id="button-back">
      <b-button
        @click="backbutton"
        class="button button-close"
        squared
        variant="outline-danger"
        >Back</b-button
      >
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
        
        imageSelected(e){

            this.avatar = e.target.files[0];

            let reader = new FileReader();

            reader.readAsDataURL(this.avatar);
            reader.onload = e =>{

            this.preview = e.target.result;

            };


        },


        profileUpload(){

            let data = new FormData();

            data.append('image', this.avatar);

            axios.post('/api/uploadAvatar', data).then(()=>{

            }).catch(()=>{

            })
        },
         backbutton() {
         this.$router.push({ name: "dashboard" });
        },
  

    
        
    }    
    
}

</script>

<style>
form{
    margin-top: 50px;
    margin-left: auto; 
    margin-right: auto; 

}
#button-back {
 margin-left: 42px;
}
#button-alert {
  float: right;
}

#inputGroupFile04{
    width: 40%;
}
#inputs{
    width: 150px;
    margin-left: auto; 
    margin-right: auto; 
}
#upload{
    margin-left: 600px;
    
}
#img{
    margin-bottom: 50px;
}
</style>