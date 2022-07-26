# Income-and-Expenditure
`Expense Tracker` `Track Income` `Track Expense` <br>

## Description
<p>
<b>Budget</b> is a simple web app that provides a means for users to record their income and expenses. It helps you to keep track of your spending.
Budget is written in pure php. An <b>advanced version</b> with more feature and functionalites, develoeped using laravel, can be found <a href="https://github.com/Timadey/budget">here</a>
</p>

## Features

* Authentication
* Create multiple accounts or books
* Record Income
* Record Expense


## Techonologies used

Languages 
* `PHP`
* `MYSQL`
* `HTML` 
* `CSS`
* `JS`

Dependency Manager
* `composer`

## Configuration

### Database Structure

> Category Table must be filled with `Income` category and `Expense` category. <br>
> Sub category table must be filled with any sub category of your choice
> each sub category belonging to a catgory.
> For example, sub categories `movies`, `food`, `entertainment` can belong to the `expense` category
> on the other hand sub categories `salary`, `bonus`, `gift` can belong to the `income` catgeory.
<hr>
Below is the database structure, define `foreign constraint` where neccessary
<table>
    <thead>
        <tr>
            <th>Table</th>
            <th>Columns</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>users</td>
            <td>user_id, first_name, last_name, email, password, date_registered</td>
        </tr>
        <tr>
            <td>books</td>
            <td>book_id, user_id, book_name, book_desc, book_date, category_id</td>
        </tr>
        <tr>
            <td>transactions</td>
            <td>transaction_id, user_id, book_id, category_id, type, sub_category_id, transaction_amount, transaction_desc, transaction_date</td>
        </tr>
        <tr>
            <td>category</td>
            <td>category_id, category_name, category_desc</td>
        </tr>
        <tr>
            <td>category</td>
            <td>sub_category_id, category_id, sub_category_name</td>
        </tr>
    </tbody>
</table>

### Database configuration 
The only configuration needed is in the [`config/config.php file`](config/config.php), open it and set your `Database Configurations`.

### Ready made database
A [`budget.sql file`](budget.sql) is availabe at the root of this repo.
 <!-- but it's outdated. If you're going to use it. <b>Ensure that you do the following after importing</b>

* Delete the `category_id` column in `books` table
* Rename the `type` column in `transactions` table to `category_id` or simply create a new `category_id` column and delete `type` -->
<br>
<!-- ## Live Test
Coming soon... -->
