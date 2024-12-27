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
     * convert persian date to gregorian
     * @param {Array} indate
     * @returns {Array}
     */
    persian2Gregorian = function (indate) {

        let jy = parseInt(indate[0]);
        let jm = parseInt(indate[1]);
        let jd = parseInt(indate[2]);

        var gy=(jy<=979)?621:1600;
        jy-=(jy<=979)?0:979;
        var days=(365*jy) +((parseInt(jy/33))*8) +(parseInt(((jy%33)+3)/4))
            +78 +jd +((jm<7)?(jm-1)*31:((jm-7)*30)+186);
        gy+=400*(parseInt(days/146097));
        days%=146097;
        if(days > 36524){
            gy+=100*(parseInt(--days/36524));
            days%=36524;
            if(days >= 365)days++;
        }
        gy+=4*(parseInt((days)/1461));
        days%=1461;
        gy+=parseInt((days-1)/365);
        if(days > 365)days=(days-1)%365;
        var gd=days+1;
        var sal_a=[0,31,((gy%4==0 && gy%100!=0) || (gy%400==0))?29:28,31,30,31,30,31,31,30,31,30,31];
        var gm
        for(gm=0;gm<13;gm++){
            var v=sal_a[gm];
            if(gd <= v)break;
            gd-=v;
        }
        return [gy,gm,gd];
    }


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
