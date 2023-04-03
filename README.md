# Promptly

This is a project for the course PHP in my education. It is a credit-based platform/website where users can find, sell, and buy prompts for machine learning models.

<br/>

## Design & work files

figma design file: https://www.figma.com/file/BwfNtmZc51Pu2kKwhkbk2M/PHP-prompting?node-id=1%3A2&t=ZvaVA7gr7d1W9LnH-1

figmajam file: https://www.figma.com/file/dwz1cgqwnZ96frLyCjyUx4/PHP-prompting?node-id=0%3A1&t=VlvpwhqB8V4gvjbm-1

Trello Design Board: https://trello.com/b/Mk0EFYDM/design

Trello Development Board: https://trello.com/b/KGqDXzKQ/development

<br/>

## To contributors

### Setup

#### Pulling the repository

First step is to pull the repository. You do this by first creating a new folder in your htdocs directory named promptly. This folder you open with VS code. You then open a git bash terminal, copy the SSH from the github repository, and execute the following commands:

```
git init
git pull [SSH]
```

congratulations you should now have pulled the repository.

#### Config.ini

When first starting to work on this project, create a folder called config. In this folder create a file named config.ini. This file will contain your database information.

use the following structure:

```
[ Database ]
db_name = 
db_user =
db_password =
db_host =
```

</br>

### How to work on this project

#### Working with branches

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

#### CSS files

Every page needs to include main.css. This is a document with basic classes, setup, variables, css reset, and so on. Do not change this document unless you know what you're doing! Read through the css variables to understand them. You can work with them in another css document as follows:

```
.class {
  background-color: var(--variable-name);
}
```

To keep loading times to a minimum we also don't want the css files that we send to be too big. Create thus a new css file for each page (EXCEPT IF THE PAGE LOOKS SIMILAR TO ANOTHER PAGE). think about if it's worth creating a new css file or if there is too much overlap with another page and you'll just use and add to that existing css file. 
