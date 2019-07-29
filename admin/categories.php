<?php ob_start(); ?>
<?php include("includes/admin_header.php") ?>
    <div id="wrapper">
       
        <?php include("includes/admin_navigation.php") ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $_SESSION['user_firstname'] . " "; echo $_SESSION['user_lastname'];?>
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                    <div class="col-xs-6"> 
                       
                       <?php insert_categories(); ?> 
                       
                          
                             <?php 
                        
                            cloneCategories();
                        
                        ?>
                                
                                   
                                         
                       
                    <form action="" method="post">
                           
                            <div class="form-group">
                                 <label for="cat_title"> Add Category </label>   
                                 <input class="form-control input-background" type="=text" name="cat_title">
                            </div>
                            <div class="form-group ">
                                <input class="btn btn-success submit-buttons" type="submit" name="submit" value="Add Category">
                            </div>
                        
                        <?php 
                        if(isset($_GET['edit'])) {
                            $cat_id = $_GET['edit'];
                           include("includes/update_categories.php"); 
                        }
                         ?>
                    </div>
                    
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover tr-background">
                          <div class="row">
                           <div id="bulkOptionsContainer" class="col-xs-4">
                             <select class="form-control input-background" id="" name="bulk_options">
                                 
                                 <option value="">Select Options</option>
                                 <option value="Delete">Delete </option>
                                 <option value="Clone">Clone</option>
                                 
                             </select> 
                             
                            </div>
                              <div class="col-xs-4">
                                <input type="submit" name="submit" class="btn btn-success submit-buttons" value="Apply"> 
                              </div> 
                            <thead>
                               <th><input id="selectAllBoxes" type="checkbox" class="checkbox-color"></th>
                                <th>
                                    ID
                                </th>
                                <th>
                                Category Title
                                </th>
                                <th>
                                Edit
                                </th><th>
                                Delete
                                </th>
                                
                            </thead>
                            <tbody>
                               <?php findAllCategories() ?>  

                                
                                <?php deleteCategories() ?>
                                    
                            </tbody>
                        </table>
                        
                     
                    </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
    
        <!-- /#page-wrapper -->
        
        <?php include("includes/admin_footer.php") ?>
