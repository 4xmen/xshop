/**
 *
 * @param key
 * @param makeNumber [0 = nothing ,1 = integer, 2 = float]
 * @returns {any[]}
 */
Array.prototype.subItem = function (key, makeNumber = 0) {
    return this.map(item => {
        if (makeNumber == 2){
            return  parseFloat(item[key]);
        }else if(makeNumber == 1){
            return  parseInt(item[key]);
        }else{
            return item[key];
        }
    });
};
