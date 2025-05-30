/** @param {string} string */
export function hashStringToUnitInterval(string) {
    let hash = 0;

    for (let i = 0; i < string.length; ++i) {
        hash = (hash << 5) - hash + string.charCodeAt(i);
        hash |= 0;
    }

    return (hash >>> 0) / 0xffffffff;
}
