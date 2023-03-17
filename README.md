# Promptly

This is a project for the course PHP in my education. It is a platform/website where users can find, sell, and buy prompts for AI's.

## To contributors

Try using branches to work on features. Commands are as follows:

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
