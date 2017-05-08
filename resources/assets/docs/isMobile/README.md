# isMobile

A simple JS library that detects mobile devices.

## Why use isMobile?

You probably shouldn't use this library unless you absolutely have to. In most cases, good [responsive design](https://en.wikipedia.org/wiki/Responsive_web_design) solves the problem of controlling how to
render things across different screen sizes. But there are always edge cases. If you have an edge case,
then this library might be for you.

I had very specific requirements for a project when I created this:

**`- Redirect all iPhones, iPods, Android phones, and seven inch devices to the mobile site.`**

## How it works

isMobile runs quickly during initial page load to detect mobile devices; it then creates a JavaScript object with the results.

## Devices detected by isMobile

The following properties of the global `isMobile` object will either be `true` or `false`

### Apple devices

* `isMobile.apple.phone`
* `isMobile.apple.ipod`
* `isMobile.apple.tablet`
* `isMobile.apple.device` (any mobile Apple device)

### Android devices

* `isMobile.android.phone`
* `isMobile.android.tablet`
* `isMobile.android.device` (any mobile Android device)

### Amazon Silk devices (also passes Android checks)

* `isMobile.amazon.phone`
* `isMobile.amazon.tablet`
* `isMobile.amazon.device` (any mobile Amazon Silk device)

### Windows devices

* `isMobile.windows.phone`
* `isMobile.windows.tablet`
* `isMobile.windows.device` (any mobile Windows device)

### Specific seven inch devices

* `isMobile.seven_inch`
	* `true` if the device is one of the following 7" devices:
		- Nexus 7
		- Kindle Fire
		- Nook Tablet 7 inch
		- Galaxy Tab 7 inch

### "Other" devices

* `isMobile.other.blackberry_10`
* `isMobile.other.blackberry`
* `isMobile.other.opera` (Opera Mini)
* `isMobile.other.firefox`
* `isMobile.other.chrome`
* `isMobile.other.device` (any "Other" device)

### Aggregate Groupings

* `isMobile.any` - any device matched
* `isMobile.phone` - any device in the 'phone' groups above
* `isMobile.tablet` - any device in the 'tablet' groups above


## Example Usage

```javascript
import { isMobile } from '@/utils';
console.log(isMobile(req.headers['user-agent']).any);

console.log(isMobile(req.headers['user-agent']).isIOS());
```
