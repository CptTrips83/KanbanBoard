let localeConfig = "de-DE";

/**
 * Sets the locale for the date conversion.
 *
 * @param {string} locale - The locale to set. Defaults to "de" if not provided.
 *
 * @return {void}
 */
export function setLocale(locale) {
    localeConfig = locale || "de-DE";
}

/**
 * Returns a formatted date and time string.
 *
 * @param {string} date - The date value to be converted. Must be a valid date string.
 * @param {string} [preText=""] - Additional text that will be prepended to the formatted date and time string. Optional.
 * @param {string} [midText=""] - Additional text that will be inserted between the date and time in the formatted string. Optional.
 * @param {string} [appendText=""] - Additional text that will be appended to the formatted date and time string. Optional.
 * @returns {string} The formatted date and time string.
 */
export function getDateTimeString(date, preText = "", midText = "", appendText = "") {
    if(date === "") return "";
    const parsedDate = new Date(Date.parse(date));

    return `${preText} ${convertDate(parsedDate)} ${midText} ${convertTime(parsedDate)} ${appendText}`;
}

/**
 * Returns a formatted date string.
 *
 * @param {string} date - The input date string.
 * @param {string} [preText=""] - The text to prepend to the formatted date string.
 * @param {string} [appendText=""] - The text to append to the formatted date string.
 * @returns {string} The formatted date string.
 */
export function getDateString(date, preText = "", appendText = "") {
    if(date === "") return "";
    const parsedDate = new Date(Date.parse(date));

    return `${preText} ${convertDate(parsedDate)} ${appendText}`;
}

/**
 * Returns a formatted time string.
 *
 * @param {string} date - The date and time to be converted.
 * @param {string} [preText=""] - The text to be prepended to the time string.
 * @param {string} [appendText=""] - The text to be appended to the time string.
 * @returns {string} - The formatted time string.
 */
export function getTimeString(date, preText = "", appendText = "") {
    if(date === "") return "";
    const parsedDate = new Date(Date.parse(date));

    return `${preText} ${convertTime(parsedDate)} ${appendText}`;
}

/**
 * Converts the given date to a localized string representation.
 *
 * @param {Date} date - The date to be converted.
 * @return {string} - A localized string representation of the date.
 */
export function convertDate(date) {
    return `${date.toLocaleDateString(localeConfig)}`;
}

/**
 * Converts the given date to a localized time string.
 *
 * @param {Date} date - The date to convert.
 * @return {string} - The converted time string.
 */
export function convertTime(date) {
    return `${date.toLocaleTimeString(localeConfig)}`;
}