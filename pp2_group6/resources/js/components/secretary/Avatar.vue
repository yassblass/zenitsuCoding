<template>
    <div v-if="user">

        <navbar></navbar>
        <form @submit.prevent="profileUpload" methode="POST">

            <div v-if="preview == null">
                <img class="center" :src="src" style="width: 100px; height:100px; border-radius:50%; ">
            </div>
            <div v-if="preview">
                <img class="center" :src="preview" style="width: 100px; height:100px; border-radius:50%; ">
            </div>
            
            <input type="file" @change="imageSelected" name="fileToUpload" id="fileToUpload" >

            <button type="submit" value="Upload Image" name="submit">Upload image</button>
        </form>

   

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
  

    
        
    }    
    
}

</script>