<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>xShop installer</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet"
          type="text/css"/>
    <style>
        * {
            font-family: Vazirmatn, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: #282c34;
            color: white;
        }

        h1, h2, h3, h4 {
            font-weight: 200;
        }

        svg {
            width: 75%;
            height: auto;
        }

        h2 {
            color: red;
            padding: .5rem;
            border-bottom: 1px solid darkred;
            margin-bottom: 1rem;
        }

        b {
            color: yellow;
        }

        form{
            padding: .5rem 1.5rem;
        }

        ul{
            padding: 2rem;
        }

        li{
            margin-bottom: 1rem;
        }
        code{
            background: #111;
            padding: 1rem;
            display: block;
            margin-top: 1rem;
        }
        input{
            border: 0;
            border-bottom: 1px solid white;
            background: #ffffff77;
            display: block;
            padding: 2px;
            width: 100%;
            margin-bottom: 7px;
        }

        #installer {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            min-height: 100vh;
        }

        #installer > div {
            padding: 1rem;
        }

        #installer > div:first-child {
            background: #1b2739;
        }

        #installer > div:last-child {
            text-align: center;
        }

        #progress {
            width: 95%;
            border: 1px solid darkred;
            border-radius: 5px;
            padding: 2px;
            box-shadow: 0 0 7px darkred;
        }

        #bar {
            width: 10%;
            font-size: 17px;
            margin: 0;
            background: red;
            border-radius: 5px;
            text-align: center;
        }

        #percent {
            display: inline-flex;
            align-items: center;
            justify-self: center;
            padding-top: 3px;
            color: white;
        }

        #percent:after {
            content: "%";
            /*mix-blend-mode: difference;*/
            color: white;
        }

        #config{
            background: #00000022;
            padding: 1rem;
        }

        .success {
            background: rgba(0, 255, 0, 0.3);

        }

        .error {
            background: rgba(255, 0, 0, 0.3);
        }

        .msg {
            padding: .5rem 1rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-self: start;
            margin-bottom: 5px;
        }

        .msg svg {
            fill: white;
            width: 25px;
            height: 25px;
            margin-right: 2rem;
        }

        .btn{
            padding: 7px;
            display: block;
            background: transparent;
            margin: 1rem auto;
            width: 50%;
            text-align: center;
            border: 1px solid white;
            border-radius: 5px;
            cursor: pointer;
            color: #FFFFFF;
            text-decoration: none;

        }

        .btn:hover{
            background: #ffffff33;
        }
    </style>
</head>
<body>
<div id="installer">
    <div id="content">
