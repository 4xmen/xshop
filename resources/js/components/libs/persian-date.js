class PersianDate {

    persianMonthNames = ['', 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

    settings= {
        gSpliter: '/',
    }

    /**
     *  from parsi date by mobin ghasem pour
     * @param {integer} year
     * @returns {Boolean}
     */
    isLeapYear = function (year) {
        if (((year % 4) === 0 && (year % 100) !== 0) || ((year % 400) === 0) && (year % 100) === 0)
            return true;
        else
            return false;
    };


    parseHindi = function (str) {

        let r = str.toString();
        let org = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        let hindi = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        for (var ch in org) {
            r = r.replace(new RegExp(org[ch], 'g'), hindi[ch]);
        }

        return r;
    }


    exploiter = function (date_txt, determ) {
        if (typeof determ === 'undefined') {
            determ = '/';
        }
        let a = date_txt.split(determ);

        if (typeof a[2] === 'undefined') {
            return a;
        }
        if (a[0].length < a[2].length) {
            return [a[2], a[1], a[0]];
        }

        return a;
    };

    imploiter = function (date_txt, determ) {
        if (determ === undefined) {
            determ = '/';
        }

        return date_txt[0] + determ + date_txt[1] + determ + date_txt[2];
    };


    /**
     * from parsi date by mobin ghasem pour
     * @param {Array} indate
     * @returns {Array}
     */
    persian2Gregorian = function (indate) {
        let jy = indate[0];
        let jm = indate[1];
        let jd = indate[2];
        let gd;
        let j_days_sum_month = [0, 0, 31, 62, 93, 124, 155, 186, 216, 246, 276, 306, 336, 365];
        let g_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        let g_days_leap_month = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        gd = j_days_sum_month[parseInt(jm)] + parseInt(jd);
        let gy = parseInt(jy) + 621;
        if (gd > 286)
            gy++;
        if (this.isLeapYear(gy - 1) && 286 < gd)
            gd--;
        if (gd > 286)
            gd -= 286;
        else
            gd += 79;
        let gm;
        if (this.isLeapYear(gy)) {
            for (gm = 0; gd > g_days_leap_month[gm]; gm++) {
                gd -= g_days_leap_month[gm];
            }
        } else {
            for (gm = 0; gd > g_days_in_month[gm]; gm++)
                gd -= g_days_in_month[gm];
        }
        gm++;
        if (gm < 10)
            gm = '0' + gm;
        gd =  gd < 10 ? '0'+gd: gd;
        return [gy, gm, gd];
    };


    /**
     * from parsi date by mobin ghasem pour
     * @param {Array} indate
     * @returns {Array}
     */
    gregorian2Persian = function (indate) {

        let gy, gm, gd, j_days_in_month, g_days_sum_month, dayofyear, leab, leap, jd, jy, jm, i;

        gy = indate[0];
        gm = indate[1];
        gd = indate[2];

        j_days_in_month = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
        g_days_sum_month = [0, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365];
        dayofyear = g_days_sum_month[parseInt(gm)] + parseInt(gd);
        leab = this.isLeapYear(gy);
        leap = this.isLeapYear(gy - 1);
        if (dayofyear > 79) {
            jd = (leab ? dayofyear - 78 : dayofyear - 79);
            jy = gy - 621;
            for (i = 0; jd > j_days_in_month[i]; i++) {
                jd -= j_days_in_month[i];
            }
        } else {
            jd = ((leap || (leab && gm > 2)) ? 287 + dayofyear : 286 + dayofyear);
            jy = gy - 622;
            if (leap == 0 && jd == 366)
                return [jy, 12, 30];
            for (i = 0; jd > j_days_in_month[i]; i++) {
                jd -= j_days_in_month[i];
            }
        }
        jm = ++i;
        jm = (jm < 10 ? jm = '0' + jm : jm);
        if (jm == 13) {
            jm = 12;
            jd = 30;
        }
        if (jm.toString().length == 1) {
            jm = '0' + jm;
        }
        if (jd.toString().length == 1) {
            jd = '0' + jd;
        }
        return [jy.toString(), jm, jd];
    };

    convertDate2Persian = function (dt){
        let tmp = dt.toLocaleString('fa-IR-u-nu-latn')
            .split('،')
            .join(',');
        let date = tmp.split(',');
        let result = date[0].split('/');
        result[1] = this.make2number(result[1]);
        result[2] = this.make2number(result[2]);
        return result;

    }
    make2number = function (instr) {
        let num = instr.toString();
        return num.length === 2 ? num : '0' + num;
    }

    gDate2Timestamp = function (stri) {
        return Math.round(new Date(stri + " 00:00:00").getTime() / 1000);
    }

    gTimestamp2Date = function (unix_timestamp) {
        let date = new Date(unix_timestamp * 1000);
        return date.getFullYear() + settings.gSpliter + date.getMonth() + 1 + settings.gSpliter + date.getDate();
    }
    pDate2Timestamp = function (stri) {
        return this.gDate2Timestamp(this.imploiter(this.persian2Gregorian(this.exploiter(stri))));
    }

    pTimestamp2Date = function (unix_timestamp) {
        let date = new Date(unix_timestamp * 1000);
        return this.imploiter(this.gregorian2Persian([date.getFullYear(), date.getMonth() + 1, date.getDate()]));
    }

    getPersianWeekDay = function (jdate) {

        let tmp = this.imploiter(this.persian2Gregorian(this.exploiter(jdate)), '/');
        let dd = new Date(tmp + " 00:00:00").getDay() + 1;
        if (dd > 6) {
            dd -= 7;
        }
        return dd;
    };

    pGetLastDayMonth = function (mn, yr) {
        let tmp;
        let last = 29;
        let now = this.pDate2Timestamp(yr + '/' + mn + '/' + (29));
        for (let i = 1; i < 4; i++) {
            now += 86400;
            tmp = this.exploiter(this.pTimestamp2Date(now));
            if (tmp[2] < last) {
                return last;
            } else {
                last = tmp[2];
            }
        }
        return last;
    }

}

export default PersianDate;
