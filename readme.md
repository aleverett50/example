# Example e-Commerce Structure

This is a scaled down e-Commerce store structure. All the functionality can be found in the classes folder. Classes are called using the autoload function in the config file. All classes and functionality have been created from scratch.

This set up is used on all e-Commerce stores and any other database related applications. It's easy to use and saves time. It has server side validation and prepared statements to help prevent SQL injection.

Each database table has its own class, with a strict naming convention. Each table class extends the class ObjectModel which is where database queries for each table are executed.

There are several aspects which I have taken from other frameworks such as Laravel and Presta Shop, which I liked the look of, and used these to good effect.