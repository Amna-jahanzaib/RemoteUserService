<template>
    
    <Head title="Open APIs Dashboard" />

    <div class="max-w-7xl m-auto rounded-md shadow p-4 mt-5 border">

        <div class="flex justify-start items-center gap-5">
            <h1 class="text-2xl inline-block">Public APIs</h1>
            <span>A list of publically available, free to use APIs</span>
			<button  class="btn rounded-md shadow p-4 mt-5 border" @click="getCategories">Show Categories</button>        </div>
		<div class=" mt-5">
		<table class="w-full border p-5 mt-4" >
		<thead>
			<tr>
				<th>Categories</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(category,i) in categories" :key="i">
				<td>{{category}}</td>

			</tr>

		</tbody>
		</table>
		</div>
        <div class="mt-5">
			
            <table class="w-full border" ref="el" >
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>API</th>
                        <th>Auth</th>
                        <th>HTTPS</th>
                        <th>Cors</th>
                        <th>Description</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
				
                    <tr  v-for="(item, index) in data" :key="index" >
					<td>{{item.Category}}</td>
					<td>{{item.API}}</td>
					<td>{{item.Auth}}</td>
					<td>{{item.HTTPS}}</td>
					<td>{{item.Cors}}</td>
					<td>{{item.Description}}</td>
					<td>{{item.Link}}</td>
					</tr>
                    <!-- Results -->

                </tbody>
            </table>

        </div>

    </div>

</template>

<script >

	import { ref, onMounted } from 'vue'

	export default{
		
		data(){
			return{
				data:[],
				categories:[]
		}
		},

		methods:{
		getData() {
				
				fetch('https://api.publicapis.org/entries')
  				.then(resp => resp.json())
				.then(json => this.data=json.entries)
			},
		getCategories(){
			this.categories=this.data.map(item => item.Category)
  			.filter((value, index, self) => self.indexOf(value) === index)

		},
 		 
		},
		mounted() {
			this.getData()
		},
		
	}
 
</script>

<style>
.btn{
	background-color: #04AA6D!important;
    border-radius: 5px;
    font-size: 17px;
    font-family: 'Source Sans Pro', sans-serif;
    padding: 6px 18px;
	color:white;
}
</style>