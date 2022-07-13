<div clas="container h-100">
        <div class="row justify-content-md-center h-100">
                <div class="card">
                        <div class="card-header">
                                Budget
                        </div>
                                
                        <?php
                         echo ($_SESSION['msg']) ?? "";
                         unset($_SESSION['msg']);
                        if (is_array($error))
                        {
                                echo "<div class = 'alert alert-danger' role = 'alert'><strong>";
                                foreach ($error as $err)
                                {
                                        echo $err.'<br>';
                                }
                                unset($error);
                                echo "</strong></div>";
                        }
                        ?>
                                        
                        <div class="card-body">
                                <h5 class="card-title"><a style="text-decoration:none" href="<?php echo $view_book; ?>">View book</a> / <?php echo $edit; ?></h5>
                                
                                <form method="POST" action="<?php echo $form_action; ?>" class="my-login-validation" novalidate="">
                                        <div class="form-group">
                                                <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $book_id;?>" hidden>
                                                <label for="book-name">Book Name</label>
                                                <input id="book-name" type="" class="form-control" name="book-name" value= "<?php echo $book_name;?>" required autofocus>
                                                <div class="invalid-feedback">
                                                Book name is needed
                                                </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                                <label for="book-desc">Description</label>
                                                <textarea class="form-control" id="book-desc" name="book-desc" rows="3" required><?php echo $book_desc;?></textarea>
                                        </div><br>
                                        <div class="form-group m-0">
                                                <button type="submit" id="<?php echo $button_id;?>" name="<?php echo $button_name;?>" class="btn btn-primary btn-block">
                                                <?php echo $button_label;?>
                                                </button>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
</div>