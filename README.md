# xShop2

## make xcontroller

Controller with log and semi-automatic CURD with logs  
User [`model`]

```bash
php artisan make:xcontroller User
```



## make theme part 

Theme part usable in area

PartName [`theme aprt name`]

segmentName [`group`, `category`, `preloader`, ...], 

```bash
php artisan  make:part PartName segmentName
```

## client optimize 
Optimize client assets, `scss`,`js`,`css`

```bash
php artisan  client
```
### theme parts file

- PartName.php: `onCreate`, `onRemove`, `onMount` actions of theme part
- PartName.blade.php: your theme part blade code 
- PartName.scss: your theme part scss
- PartName.js: your theme part javascript
- screenshot.png: screenshot preview of theme part


<p align="center"> 
    Developed With Love ! ❤️
</p>
