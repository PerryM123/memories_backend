## TODO:
- I have so many TODO comments... Let's solve and reduce them by a lot
- Is it possible to add a prettier to php laravel files so that trailing commas won't be allowed????

## My Notes:
- Can create users 
- Users can:
  - login
  - logout
  - Make posts
  - View posts
  - Edit posts
  - Delete posts
  - Create groups
  - View groups
  - Edit groups
  - Delete groups
  - Join groups
  - Leave groups
  
## DDD Directories
- src/app/
- src/app/Http/Controllers/
- src/app/Domain/Posts/
- src/app/Domain/Groups/
- src/app/Domain/Users/
- src/app/Infrastructure/

Memo:
- what are aggregates?
- learn to make domain model diagram and UML diagrams
- this video explains DDD really well: https://www.youtube.com/watch?v=xFl-QQZJFTA
- My attempt at making a domain model diagram WIP - https://docs.google.com/drawings/d/1PJz5o-38sGwTrR85deDQWcsypC9P6T8qKuEDyXv7Epo/edit

## Domains
- 

## Entities
- 

## Value Objects
- 

## Services
- 

## Repositories
-  

In the future:
- Users can see their profile
- Users can edit their profile
- Users can delete their profile
- Users can see other users profiles
- Users can send messages to other users

## Random notes
- Model_Name::insert() can add arrays. Model_Name::create() only creates one element
- I like this guy's DDD folder structure
  - https://medium.com/@leoonofre.oliversoft/developing-with-laravel-and-domain-driven-design-ddd-structuring-an-email-parsing-system-part-01-3a714b9f47c9
  - 日本語: https://aichi.blog/laravel-api-development-ddd-architecture/

## Factoryを使いたい場合
```php
RankInfo::factory()
    ->count(5)
    ->create();
```

### nullable return types
```php
public function findById($id): ?User
{}
```

