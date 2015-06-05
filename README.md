TechWeb -- a symfony project
=========
A Symfony project created on May 18, 2015, 9:33 am.

- Symfony 2 Framework
- Doctrine ORM
- Twig as template engine

1. user registration, login/logout (FOSUserBundle)
2. When connected, user can create a project and add members (its
members and creator will have access to a project (view and edition).
Only the creator can edit members and project information or delete the
project.)
3. Project members can manage (create, edit, delete) lists. One list
will be defined by a set of tasks that can be assigned to one or more
members (every member on the project can assign a task to another member
of the project)
4. A task can be defined as completed and must have a description and a
due date
5. A percentage of completion for a project will be accounted using the
progress of its tasks. This information will be visible on the project
view.
6. A duration for a project will be accounted using the due dates of its
tasks. This information will be visible on the project view.
7. A user can easily find out the tasks that concern him.
