import {
    Droplets,
    Flower2,
    Hand,
    Leaf,
    type LucideIcon,
    Smile,
    Sparkles,
    Waves,
} from 'lucide-vue-next';

export const categoryIconComponents = {
    Flower2,
    Droplets,
    Waves,
    Leaf,
    Smile,
    Hand,
    Sparkles,
} satisfies Record<string, LucideIcon>;

export const resolveCategoryIcon = (iconName: string): LucideIcon => {
    return categoryIconComponents[iconName] ?? Sparkles;
};

