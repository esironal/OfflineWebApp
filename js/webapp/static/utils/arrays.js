
function compare(array1, array2) {

	// both arrays = false
    if (!array1 && !array2)
        return true;

    if (!array1)
        return false;

    if (!array2)
        return false;

    // compare lengths - can save a lot of time
    if (array1.length != array2.length)
        return false;

    for (var i = 0, l = array1.length; i < l; i++) {

        // Check if we have nested arrays
        if (array1[i] instanceof Array && array2[i] instanceof Array) {

            // recurse into the nested arrays
        	if (!compare(array1[i], array2[i]))
                return false;

        } else if (array1[i] != array2[i]) {
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;
        }
    }
    return true;
}


/*
 * 
 * http://stackoverflow.com/questions/8859828/javascript-what-dangers-are-in-extending-array-prototype
 * 

Array.prototype.compare = function (array) {
// if the other array is a falsy value, return
if (!array)
    return false;

// compare lengths - can save a lot of time
if (this.length != array.length)
    return false;

for (var i = 0, l=this.length; i < l; i++) {
    // Check if we have nested arrays
    if (this[i] instanceof Array && array[i] instanceof Array) {
        // recurse into the nested arrays
        if (!this[i].compare(array[i]))
            return false;
    }
    else if (this[i] != array[i]) {
        // Warning - two different object instances will never be equal: {x:20} != {x:20}
        return false;
    }
}
return true;
}
*/