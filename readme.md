# Example e-Commerce Structure

This is a scaled down e-Commerce store structure. All the class functionality can be found in the app/ folder. Classes are loaded using composer and the PSR-4 namespace / naming convention. All classes and functionality have been created from scratch.

This set up is used on all e-Commerce stores and any other database related applications. It's easy to use and saves time. It has server side validation and prepared statements to help prevent SQL injection.

Each database table has its own class which extends the class ObjectModel, which is where database queries for each table are executed. There are several helper classes found in app\Helpers that are not necessarily table specific.

There are several aspects that I have taken from other frameworks such as Laravel and Presta Shop, which I liked the look of, and use these to good effect.