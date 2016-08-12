var routerApp = angular.module('routerApp',['ui.router']);

routerApp.config(function($stateProvider){
    $stateProvider
    .state("content1", {
        templateUrl: "content1.html"
    })
    .state("content2", {
        templateUrl: "content2.html"
    })
    .state("content3", {
        templateUrl: "content3.html"
    })
    .state("content4", {
        templateUrl: "content4.html"
    })
    .state("content5", {
        templateUrl: "content5.html"
    })
    .state("content6", {
        templateUrl: "content6.html"
    })
    .state("content7", {
        templateUrl: "content7.html"
    })
    .state("content8", {
        templateUrl: "content8.html"
    })
    .state("content9", {
        templateUrl: "content9.html"
    })
    .state("content10", {
        templateUrl: "content10.html"
    })
    .state("content11", {
        templateUrl: "content11.html"
    })
    .state("content12", {
        templateUrl: "content12.html"
    })
    .state("content13", {
        templateUrl: "content13.html"
    });
     
}).controller('myCtl',function($scope,$state){
    $state.go('content1');
});