<?php
        if ($transactions == NULL){?>
           <div class="card text-center">
                <div class="card-header">
                    Transactions
                </div>
                <div class="card-body">
                <?php
                    echo ($_SESSION['msg']) ?? "";
                    unset($_SESSION['msg']);
                ?>
                    <h5 class="card-title"><?php echo $book['book_name'];?></h5> 
                    <p class="card-text">No transaction found in this book. <br> Log a new transaction in this book to view it.</p>
                    <a href="transaction/addnew?book=<?php echo $book_id;?>" class="btn btn-outline-primary">Log a transaction</a>
                    <a href="/book/delete?book=<?php echo $book_id;?>">
                        <button onclick="return confirm('You\'re trying to delete an entire book. All data and recorded transaction will be deleted, continue?')" 
                        class="btn btn-outline-danger">Delete</button>
                    </a>
                </div>
                <div class="card-footer text-muted">
                    © 2022
                </div>
            </div>
        <?php }
        else{?>
            <div class="card text-center">
                <div class="card-header">
                    Transactions
                </div>
                <?php
                    echo ($_SESSION['msg']) ?? "";
                    unset($_SESSION['msg']);
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $book['book_name'];?></h5>
                    <p><?php echo $transactions[0]['book_desc'];?></p>
                    <?php
                         $book['book_id'] = $book_id;
                         $book['book_desc'] = $transactions[0]['book_desc'];
                         $rbook = http_build_query($book);
                    ?>
                    <p>
                        <a href="/book/edit?<?php echo $rbook;?>"><button class="btn btn-outline-primary">Edit Book</button></a>
                        <a href="transaction/addnew?book=<?php echo $book_id;?>"><button class="btn btn-outline-success">Log Transaction</button></a>
                        <a href="/book/delete?book=<?php echo $book_id;?>">
                        <button onclick="return confirm('You\'re trying to delete an entire book. All transactions and recorded transaction will be deleted, continue?')" 
                        class="btn btn-outline-danger">Delete</button></a>
                    </p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Category</th>
                                <th scope="col" style="width:5%">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $key => $transaction) {?>
                            <tr>
                                <th scope="row"><?php echo $key+1 ?></th>
                                <td <?php echo $transaction['category_id'] == 2 ? "style='color:red'":" style='color:green'";?>><?php echo "NGN ".$transaction['transaction_amount'];?></td>
                                <td><?php echo $transaction['sub_category_name'];?></td>
                                <td style="width:25%"><?php echo $transaction['transaction_desc'];?></td>
                                <td><?php echo $transaction['transaction_date'];?></td>
                            
                                <td>
                                    <span class="btn-group">
                                        <form action="transaction/edit" method="post">
                                            <input name="book-id" value="<?php echo $book_id;?>" hidden/>
                                            <input name="transaction-id" value="<?php echo $transaction['transaction_id'];?>" hidden/>
                                            <input name="sub-category-id" value="<?php echo $transaction['sub_category_id'];?>" hidden/>
                                            <input name="transaction-amount" value="<?php echo $transaction['transaction_amount'];?>" hidden/>
                                            <input name="transaction-desc" value="<?php echo $transaction['transaction_desc'];?>" hidden/>
                                            <input name="category-id" value="<?php echo $transaction['category_id'];?>" hidden/>
                                            <button style="border:1px" class="btn btn-outline-primary" type="submit" name="edit-transaction-form">Edit</button>
                                        </form>
                                    </span>
                                </td>
                            <?php };?>
                            </tr>
                            
                        </tbody>
                        
                    </table>

                    
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                        <li class="page-item <?php echo $page_no == 1 ? 'disabled' : ''?>" >
                            <a class="page-link" href="#" aria-label="first-page">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?php echo $page_no == 1 ? 'disabled' : ''?>">
                            <a class="page-link" href="#" aria-label="Previous" >
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only"></span>
                            </a>
                        </li>
                        <?php for ($counter = 1; $counter < $total_page; $counter++)
                        {
                           echo  "<li class='page-item'><a class='page-link' href='#'>$counter</a></li>";
                        }
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only"></span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true" >&raquo;&raquo;</span>
                                <span class="sr-only"></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php };
?>