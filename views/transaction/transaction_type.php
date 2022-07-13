<div class='card-deck'>
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;" >
                <div class="card-header">Log Transactions</div>
                <div class="card-body">
                        <h5 class="card-title"><?php echo $book['book_name'];?>'s Income</h5>
                        <p class="card-text">Record income and daily inflow of cash into your account.</p>
                        <a href="/transaction/add?book=<?php echo $book_id.'&cat=1';?>" class="btn btn-outline-light btn-block">Log Income</a>
                </div>
        </div>

        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">Log Transactions</div>
                <div class="card-body">
                        <h5 class="card-title"> <?php echo $book['book_name'];?>'s Expenditure</h5>
                        <p class="card-text">Track how deep you're eating your money away.</p>
                        <a href="/transaction/add?book=<?php echo $book_id.'&cat=2';?>" class="btn btn-outline-light">Log Expenditure</a>
                </div>
        </div>
</div>