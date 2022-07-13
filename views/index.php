<?php
if (is_array($data) && !empty($data)){
    //load all books ?>
        <div class="card text-center">
                <div class="card-header">
                        Budget
                </div>

                <?php
                echo ($_SESSION['msg']) ?? "";
                unset($_SESSION['msg']);
                ?>
                <div class="card-body">
                        <h5 class="card-title">Income and Expenditure</h5>
                        <table class="table table-hover">
                                <thead>
                                        <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Book Name</th>
                                        <th scope="col">Date Added</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($data as $key => $value) 
                                        {?>
                                        <tr>
                                                <th scope="row"><?php echo $key + 1 ?></th>
                                                <td><a style="text-decoration:none" href="book?book=<?php echo $value['book_id'];?>"><?php echo $value['book_name'];?></a></td>
                                                <td><?php echo $value['book_date'];?></td>
                                        </tr>

                                        <?php 
                                        };?>
                                </tbody>
                        </table>
                </div>
        </div>
<?php 
}else{?>
        <div class="card text-center">
                <div class="card-header">
                        Budget
                </div>
                <div class="card-body">
                        <h5 class="card-title">Income and Expenditure</h5>
                        <p class="card-text">Record and keep tracks of your expensese. <br> Open <em>a new book</em> to start using <b>Budget</b></p>
                        <a href="/book/add" class="btn btn-primary">Open a New Book</a>
                </div>
                <div class="card-footer text-muted">
                        © 2022
                </div>
        </div>
        
<?php
}
?>
