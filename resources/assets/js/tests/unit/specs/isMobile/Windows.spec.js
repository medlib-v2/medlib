import { isMobile } from '../../../../utils/isMobile';

describe("Windows", () => {
    let mobile;
    let userAgent;

    beforeEach(() => {
        mobile    = null;
        userAgent = null;
    });

    describe("Windows Phone UserAgent", () => {

        beforeEach(() => {
            userAgent = "Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)";
            mobile = isMobile.parse(userAgent);
        });

        it("should be a Windows Phone device", () => {
            expect(mobile.windows.phone).toBe(true);
        });

        it("should not be an Android device", () => {
            expect(mobile.android.device).not.toBe(true);
        });

        it("should not be an Apple device", () => {
            expect(mobile.apple.device).not.toBe(true);
        });

        it("should be matched as Any Phone", () => {
            expect(mobile.phone).toBe(true);
        });

        it("should be a mobile device", () => {
            expect(mobile.any).toBe(true);
        });

    });

    describe("Windows Tablet UserAgent", () => {

        beforeEach(() => {
            userAgent = "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; ARM; Trident/6.0; Touch)";
            mobile = isMobile.parse(userAgent);
        });

        it("should be a Windows Tablet device", () => {
            expect(mobile.windows.tablet).toBe(true);
        });

        it("should not be a Windows Phone device", () => {
            expect(mobile.other.windows).not.toBe(true);
        });

        it("should not be an Android device", () => {
            expect(mobile.android.device).not.toBe(true);
        });

        it("should not be an Apple device", () => {
            expect(mobile.apple.device).not.toBe(true);
        });

        it("should be matched as Any Tablet", () => {
            expect(mobile.tablet).toBe(true);
            expect(mobile.isTablet()).toBe(true);
        });

        it("should be a mobile device", () => {
            expect(mobile.any).toBe(true);
        });

    });

    describe("Windows Touch Laptop UserAgent", () => {

        beforeEach(() => {
            userAgent = "Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; MAGWJS; rv:11.0) like Gecko";
            mobile = isMobile.parse(userAgent);
        });

        it("should not be a Windows Tablet device", () => {
            expect(mobile.windows.tablet).not.toBe(true);
        });

        it("should not be a Windows Phone device", () => {
            expect(mobile.other.windows).not.toBe(true);
        });

        it("should not be an Android device", () => {
            expect(mobile.android.device).not.toBe(true);
        });

        it("should not be an Apple device", () => {
            expect(mobile.apple.device).not.toBe(true);
        });

        it("should not be matched as Any Tablet", () => {
            expect(mobile.tablet).not.toBe(true);
        });

        it("should not be a mobile device", () => {
            expect(mobile.any).not.toBe(true);
        });
    });
});