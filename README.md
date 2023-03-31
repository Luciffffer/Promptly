# Promptly

This is a project for the course PHP in my education. It is a platform/website where users can find, sell, and buy prompts for AI's.

<br/>

## Design & work files

figma design file: https://www.figma.com/file/BwfNtmZc51Pu2kKwhkbk2M/PHP-prompting?node-id=1%3A2&t=ZvaVA7gr7d1W9LnH-1

figmajam file: https://www.figma.com/file/dwz1cgqwnZ96frLyCjyUx4/PHP-prompting?node-id=0%3A1&t=VlvpwhqB8V4gvjbm-1

Trello Design Board: https://trello.com/b/Mk0EFYDM/design

Trello Development Board: https://trello.com/b/KGqDXzKQ/development

<br/>

## To contributors

### Setup

When first starting to work on this project, create a folder called config. In this folder create a file named config.ini. This file will contain your database information.

use the following structure:

```
  ; Enter your database information
  [ Database ]
  db_name = 
  db_user =
  db_password =
  db_host =
```

</br>

### How to work on this project

Try using branches to work on features. For each feature you work on, create a new branch. Commit changes in this branch. When finished, merge and delete branch. Commands are as follows:

<br/>

1. Add a branch and navigate to it:
```
  git checkout -b [branch-name]
```
 
2. Navigate to a branch:
```
  git checkout [branch-name]
```
 
3. Merging the branch to the master branch:

```
  git checkout master
  git merge [branch-name]
  git branch -d [branch-name]
```

<br/>

A common workflow would be as follows

``` 
  git checkout -b new-feature main
  git add <file>
  git commit -m "Start a feature"
  git add <file>
  git commit -m "Finish a feature"
  git checkout master
  git merge new-feature
  git branch -d new-feature 
```
