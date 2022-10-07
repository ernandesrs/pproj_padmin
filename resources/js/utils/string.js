const substr = function (string, size, indicator = '...') {
    let theString = (new String(string));
    let cropped = theString.substring(0, size);
    return `${cropped + (theString.length > size && indicator ? indicator : '')}`;
}

export default {
    substr
};