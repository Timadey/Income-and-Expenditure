<div clas="container h-100">
        <div class="row justify-content-md-center h-100">
                <div class="card">
                        <div class="card-header">
                        <?php echo $book['book_name'];?>
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
                                <h5 class="card-title"><a style="text-decoration:none" href="/book?book=<?php echo $book_id;?>">View book</a> / <?php echo  'Log '.$cat_name;?></h5>
                                
                                <form method="POST" action="<?php echo $method;?>" class="my-login-validation" novalidate="">

                                        <div class="form-group">
                                                <input name="transaction-id" value="<?php echo $transaction_id;?>" hidden/>
                                                <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $book_id;?>" hidden>
                                                <input id="book-id" type="" class="form-control" name="category-id" value= "<?php echo $cat;?>" hidden>
                                                <label for="transaction-amount">Amount</label>
                                                <input id="transaction-amount" type="number" class="form-control" name="transaction-amount" value= "<?php echo $transaction_amount;?>" required autofocus>
                                        </div><br>

                                        <div class="form-group">
                                                <label for="sub-category-id">Categories</label>
                                                <select class="form-control" id="sub-category-id" name="sub-category-id" required>
                                                        <option value="">Choose...</option>
                                                        <?php foreach($sub_categories as $sub_cat => $val){?>
                                                        <option value="<?php echo $val['sub_category_id'];?>" 
                                                        <?php echo  isset($sub_category_id) && $sub_category_id == $val['sub_category_id'] ?
                                                         'selected' : '';?>><?php echo $val['sub_category_name'];?></option>
                                                        <?php }; ?>
                                                </select>
                                        </div><br>

                                        <div class="form-group">
                                                <label for="transaction-desc">Description</label>
                                                <textarea class="form-control" id="transaction-desc" name="transaction-desc" rows="3" required><?php echo $transaction_desc;?></textarea>
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