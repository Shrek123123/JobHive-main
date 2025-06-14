<?php
/**
 * Chuyển đổi giá trị USD sang VND
 *
 * @param float $usd     Số tiền tính theo USD
 * @param float $rate    Tỉ giá USD->VND (mặc định 24000)
 * @return float         Kết quả VND
 */
function convertUsdToVnd(float $usd, float $rate = 24000.0): float {
    return $usd * $rate;
}
