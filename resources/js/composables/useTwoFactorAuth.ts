import type { ComputedRef, Ref } from 'vue';
import { computed, ref } from 'vue';

export type UseTwoFactorAuthReturn = {
    qrCodeSvg: Ref<string | null>;
    manualSetupKey: Ref<string | null>;
    recoveryCodesList: Ref<string[]>;
    errors: Ref<string[]>;
    hasSetupData: ComputedRef<boolean>;
    clearSetupData: () => void;
    clearErrors: () => void;
    clearTwoFactorAuthData: () => void;
    fetchQrCode: () => Promise<void>;
    fetchSetupKey: () => Promise<void>;
    fetchSetupData: () => Promise<void>;
    fetchRecoveryCodes: () => Promise<void>;
};

const errors = ref<string[]>([]);
const manualSetupKey = ref<string | null>(null);
const qrCodeSvg = ref<string | null>(null);
const recoveryCodesList = ref<string[]>([]);

const hasSetupData = computed<boolean>(
    () => qrCodeSvg.value !== null && manualSetupKey.value !== null,
);

export const useTwoFactorAuth = (): UseTwoFactorAuthReturn => {
    const fetchQrCode = async (): Promise<void> => {
        // Mock: In a real app, fetch from API
        qrCodeSvg.value = '<svg viewBox="0 0 100 100"><rect width="100" height="100" fill="#eee"/><text x="50" y="50" text-anchor="middle" dy=".3em" font-size="10">QR Code</text></svg>';
    };

    const fetchSetupKey = async (): Promise<void> => {
        // Mock: In a real app, fetch from API
        manualSetupKey.value = 'ABCD-EFGH-IJKL-MNOP';
    };

    const clearSetupData = (): void => {
        manualSetupKey.value = null;
        qrCodeSvg.value = null;
        clearErrors();
    };

    const clearErrors = (): void => {
        errors.value = [];
    };

    const clearTwoFactorAuthData = (): void => {
        clearSetupData();
        clearErrors();
        recoveryCodesList.value = [];
    };

    const fetchRecoveryCodes = async (): Promise<void> => {
        // Mock: In a real app, fetch from API
        recoveryCodesList.value = [
            'AAAA-BBBB-CCCC',
            'DDDD-EEEE-FFFF',
            'GGGG-HHHH-IIII',
            'JJJJ-KKKK-LLLL',
            'MMMM-NNNN-OOOO',
            'PPPP-QQQQ-RRRR',
            'SSSS-TTTT-UUUU',
            'VVVV-WWWW-XXXX',
        ];
    };

    const fetchSetupData = async (): Promise<void> => {
        try {
            clearErrors();
            await Promise.all([fetchQrCode(), fetchSetupKey()]);
        } catch {
            qrCodeSvg.value = null;
            manualSetupKey.value = null;
        }
    };

    return {
        qrCodeSvg,
        manualSetupKey,
        recoveryCodesList,
        errors,
        hasSetupData,
        clearSetupData,
        clearErrors,
        clearTwoFactorAuthData,
        fetchQrCode,
        fetchSetupKey,
        fetchSetupData,
        fetchRecoveryCodes,
    };
};
