# PHP SERVER 
![Image description](https://previews.123rf.com/images/lefttime/lefttime1708/lefttime170800006/83489654-route-location-icon-three-map-pin-sign-and-road-journey-symbol-one-color-vector-illustration-isolate.jpg)

### Authentication 🛣
- **HEADER**:  ```WWW-Authenticate``` 
    - example
        ```eyJ0eXAiOiJKV1QiLCJhbGc...tDN7n3APpGXCJcly6B4-2NqoBVHanqqmAak```
## Routes lists 	
#### **User routes** 🚀
___
-  ```login```
   - [ ] `username` - string 
   - [ ] `email` - string 
   - [ ] `password` - string 
   
-  ```register```
   - [ ] `username` - string 
   - [ ] `email` OR `password`  - string 

-  ```updateprofile```
   - [ ] `firstName` - string 
   - [ ] `LastName` - string 
   - [ ] `mobile` - string       
   - [ ] `intro` - string 
   - [ ] `profile` - string 
   - [ ] `image` - string      
   
#### **Posts routes** 🚄
___      
-  ```createpost```
   - [ ] `post_title` - string 
   - [ ] `post_content` - string 
   - [ ] `tags` exmaple: `tag,tag,tag` - array OR - string 
   
-  ```delete/{postid}```
    - [ ] `no params`
-  ```updatepost/{postid}```
   - [ ] `post_title` - string 
   - [ ] `post_content` - string 
   - [ ] `tags` exmaple: `tag,tag,tag` - array OR - string 
   - [ ] `publish`  - bool 1/0
   
-  ```publish/{postid}```
   - [ ] `username`
   - [ ] `email`
   - [ ] `password`    
    
-  ```showposts/{postid}```
    - [ ] `showall` - bool 1/0
    
-  ```showposts```
    - [ ] `user` `get param` - string
    - [ ] `category` `get param` - string 
    - [ ] `page` `get param` - int

#### **Fast actions** 🚨
___
-  ```fastaction/{action}```
    - [ ] `createcategory` 
        - [ ] `category_name`  - string
        - [ ] `content_category`  - string
    - [ ] `connectcategory`
        - [ ] `postid`  - string
        - [ ] `category_name`  - string    
    - [ ] `createcomment`
        - [ ] `postid`  - string
        - [ ] `content_comment` - string   
        - [ ] `title`  - string
        - [ ] `username`  - string
    - [ ] `deletecomment`
        - [ ] `comment_id`
        - [ ] `spam` - bool 1/0   

        
