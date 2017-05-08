import { isMobile } from '../../../../utils/isMobile';

describe("Seven Inch", () => {
    let mobile;
    let userAgent;

    beforeEach(() => {
        mobile    = null;
        userAgent = null;
    });

    describe("Nexus 7", () => {
        beforeEach(() => {
            userAgent = "Mozilla/5.0 (Linux; Android 4.1.1; Nexus 7 Build/JRO03D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19";
            mobile = isMobile.parse(userAgent);
        });

        it("should be a Seven Inch device", () => {
            expect(mobile.seven_inch).toBe(true);
        });

        it("should not be an Apple device", () => {
            expect(mobile.apple.device).not.toBe(true);
        });

        it("should be a mobile device", () => {
            expect(mobile.any).toBe(true);
        });

    });
});