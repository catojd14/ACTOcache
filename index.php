<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script src='https://unpkg.com/axios/dist/axios.min.js'></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" 
	integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
    <style type="text/css">
		#overlay {
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background: rgba(0,0,0,0.6);
		}

	</style>
	
	<title>RWC Test</title>
  </head>
  <body>
  <div id='app'>
    <div class="container-fluid">

        <div class=" row mt-3">
                <div class="col-lg-12">
			
                    <h3 class="text-info">Please choose category</h3>
				    <!-- <form class="form-horizontal"> -->
                    <!-- <div class="panel-body"> -->
                     <!-- <div class="form-group"> -->
                        <label class="control-label col-sm-12">Select Category:</label>
                        <div class="col-sm-8">
                            <select class='form-control' v-model='category' @change='getDocument()'>
                              <option value='0'>Select Category</option>
                              <option v-for='cate in categories' :value='cate.id' :key="cate.id">{{ cate.category }}</option>
                            </select>
						</div>
				    	
						<div class="col-sm-4 mt-3">
							<button class="btn btn-info float-right" @click="showAddModal=true">
								<i class="fas fa-user"></i>&nbsp; &nbsp; Add Category
							</button>
						</div>
				</div>
		</div>
		<div>		
				<div>	
					<div class="row mt-3">	
						<div class="col-sm-12">
							<table class=" table table-bordered table-striped" >
								<tr class="text-center bg-info text-light">
									<th>Documents</th>
									<th>Edit</th>
									<th>Delete</th>
									<th>Add</th>
								</tr>

								<tr class="text-center"  v-for="(data) in documents" :key="data.id">
									
									<td > {{ data.name }} </td>
									<td><a href="#" class="text-success" @click="showEditModal=true">Edit</a></td>
									<td><a href="#" class="text-danger" @click="showDeleteModal=true">Delete</a></td>
									<td><a href="#" class="text-info" @click="showAddDocModal=true">Add</a></td>

								</tr>
							</table>
                		</div>
                
            		</div>       

                </div>
        </div>
				
    </div>
	<! -- add new category -->
	<div id="overlay" v-if="showAddModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New Category</h5>
				<button type="button" class="close" @click="showAddModal=false">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form action="#" method="post">
				   <div class="form-group">
						<input type="text" name="name" 
						class="form-control form-control-lg" placeholder="name">
					</div>
					<div class="form-group">
						 <button class="btn btn-info btn-block btn-lg" @click="showAddModal=false">
						   Add Category
						 </button>  
					</div>
				</form>
			</div>
		  </div>	
		</div>
	</div>

	<! -- Edit document -->
	<div id="overlay" v-if="showEditModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Document</h5>
				<button type="button" class="close" @click="showEditModal=false">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form action="#" method="post">
				   <div class="form-group">
						<input type="text" name="name" 
						class="form-control form-control-lg" placeholder="name">
					</div>
					<div class="form-group">
						 <button class="btn btn-info btn-block btn-lg" @click="showEditModal=false">
						   Edit Document
						 </button>  
					</div>
				</form>
			</div>
		  </div>	
		</div>
	</div>

	<!-- Delete a document -->

	<div id="overlay" v-if="showDeleteModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Document</h5>
				<button type="button" class="close" @click="showDeleteModal=false">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<h4 class="text-danger"> Are you sure you want to delete the document?</h4>
				<hr>
				<button class="btn btn-danger btn-lg">Yes</button>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btn btn-success btn-lg" @click="showDeleteModal=false">No</button>		
			</div>
		  </div>	
		</div>
	</div>

	<!-- Add a document -->

	<div id="overlay" v-if="showAddDocModal">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Document</h5>
				<button type="button" class="close" @click="showAddDocModal=false">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form action="#" method="post">
				   <div class="form-group">
						<input type="text" name="name" 
						class="form-control form-control-lg" placeholder="name">
					</div>
					<div class="form-group">
						 <button class="btn btn-info btn-block btn-lg" @click="showAddDocModal=false">
						   Add Document
						 </button>  
					</div>
				</form>
			</div>
		  </div>	
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
  var app = new Vue({
	  el: '#app',
  data: {
    category: 0,
    categories: '',
	documents: '',
	showAddModal: false,
	showEditModal: false,
	showDeleteModal: false,
	showAddDocModal: false,
  },
  methods: {
    getCategory: function(){
      axios.get('getCategories.php', {
        params: {
          request: 'category'
        }
      })
      .then(function (response) {
		console.log(response.data);
        app.categories = response.data;
        app.documents = '';
        
      });

    },
    getDocument: function(){
      axios.get('ajaxfile.php', {
         params: {
           request: 'documents',
           category_id: this.category
         }
      })
      .then(function (response) {
        app.documents = response.data;
		console.log(app.documents);
        // app.document = 0;    
      }); 
    } 
    
  },
  created: function(){
    this.getCategory();
  }
});
</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  </body>
</html>