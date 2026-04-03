(function () {
  const navToggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('site-nav');
  const siteHeader = document.querySelector('.site-header');
  const backtop = document.getElementById('backtop');
  const progress = document.getElementById('reading-progress');

  if (navToggle && nav) {
    const syncNavState = function (isOpen) {
      nav.classList.toggle('is-open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

      if (siteHeader) {
        siteHeader.classList.toggle('has-open-nav', isOpen);
      }
    };

    syncNavState(nav.classList.contains('is-open'));

    navToggle.addEventListener('click', function () {
      syncNavState(!nav.classList.contains('is-open'));
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 900) {
        syncNavState(false);
      }
    });
  }

  function updateScrollUi() {
    const y = window.scrollY || document.documentElement.scrollTop;
    if (backtop) backtop.classList.toggle('is-visible', y > 320);

    if (progress) {
      const doc = document.documentElement;
      const max = doc.scrollHeight - doc.clientHeight;
      const value = max > 0 ? (y / max) * 100 : 0;
      progress.style.width = value + '%';
    }
  }

  updateScrollUi();
  window.addEventListener('scroll', updateScrollUi, { passive: true });
  window.addEventListener('ag:math-ready', updateScrollUi);

  if (backtop) {
    backtop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  function initWeatherCard() {
    const card = document.getElementById('hero-weather');
    if (!card) return;

    const locationQuery = (card.dataset.location || '').trim();
    const cacheKey = 'aeroglass-weather:' + locationQuery.toLowerCase();
    const cacheMaxAge = 30 * 60 * 1000;
    const elements = {
      location: document.getElementById('weather-location'),
      pill: document.getElementById('weather-pill'),
      temperature: document.getElementById('weather-temperature'),
      summary: document.getElementById('weather-summary'),
      visual: document.getElementById('weather-visual'),
      feelsLike: document.getElementById('weather-feels-like'),
      humidity: document.getElementById('weather-humidity'),
      wind: document.getElementById('weather-wind'),
      range: document.getElementById('weather-range'),
      meta: document.getElementById('weather-meta')
    };

    function setState(state, kind) {
      card.dataset.weatherState = state;
      card.dataset.weatherKind = kind || 'clear';
    }

    function setText(node, value) {
      if (node) node.textContent = value;
    }

    function renderLoading() {
      setState('loading', 'clear');
      setText(elements.location, locationQuery || '未设置地点');
      setText(elements.pill, '更新中');
      setText(elements.temperature, '--');
      setText(elements.summary, '正在获取实时天气...');
      setText(elements.visual, '--');
      setText(elements.feelsLike, '--');
      setText(elements.humidity, '--');
      setText(elements.wind, '--');
      setText(elements.range, '--');
      setText(elements.meta, '数据源：Open-Meteo');
    }

    function renderError(message) {
      setState('error', 'clear');
      setText(elements.location, locationQuery || '未设置地点');
      setText(elements.pill, '暂不可用');
      setText(elements.temperature, '--');
      setText(elements.summary, message);
      setText(elements.visual, 'N/A');
      setText(elements.feelsLike, '--');
      setText(elements.humidity, '--');
      setText(elements.wind, '--');
      setText(elements.range, '--');
      setText(elements.meta, locationQuery ? '请稍后刷新重试' : '请在主题设置里填写天气地点');
    }

    function renderWeather(payload, options) {
      const isCached = options && options.isCached;
      setState('ready', payload.kind);
      setText(elements.location, payload.location);
      setText(elements.pill, payload.period);
      setText(elements.temperature, payload.temperature);
      setText(elements.summary, payload.summary);
      setText(elements.visual, payload.shortLabel);
      setText(elements.feelsLike, payload.feelsLike);
      setText(elements.humidity, payload.humidity);
      setText(elements.wind, payload.wind);
      setText(elements.range, payload.range);
      setText(elements.meta, isCached ? '已显示缓存天气 · ' + payload.meta : payload.meta);
    }

    function readCache() {
      if (!locationQuery) return null;

      try {
        const raw = window.localStorage.getItem(cacheKey);
        if (!raw) return null;

        const parsed = JSON.parse(raw);
        if (!parsed || typeof parsed !== 'object' || !parsed.payload) {
          return null;
        }

        return parsed;
      } catch (error) {
        return null;
      }
    }

    function writeCache(payload) {
      if (!locationQuery) return;

      try {
        window.localStorage.setItem(cacheKey, JSON.stringify({
          timestamp: Date.now(),
          payload: payload
        }));
      } catch (error) {
        return;
      }
    }

    if (!locationQuery) {
      renderError('请在主题设置中填写天气地点。');
      return;
    }

    const cached = readCache();
    if (cached && cached.payload) {
      renderWeather(cached.payload, { isCached: true });

      if (Date.now() - cached.timestamp < cacheMaxAge) {
        return;
      }
    } else {
      renderLoading();
    }

    fetchWeather(locationQuery)
      .then(function (payload) {
        writeCache(payload);
        renderWeather(payload);
      })
      .catch(function (error) {
        if (!cached || !cached.payload) {
          renderError(error && error.message ? error.message : '天气加载失败，请稍后再试。');
        }
      });
  }

  function fetchWeather(query) {
    const geocodingUrl = 'https://geocoding-api.open-meteo.com/v1/search?count=1&language=zh&format=json&name=' + encodeURIComponent(query);

    return fetchJson(geocodingUrl).then(function (geoData) {
      if (!geoData || !Array.isArray(geoData.results) || !geoData.results.length) {
        throw new Error('未找到该地点，请检查天气地点拼写。');
      }

      const location = geoData.results[0];
      const params = new URLSearchParams({
        latitude: String(location.latitude),
        longitude: String(location.longitude),
        current: 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m,is_day',
        daily: 'temperature_2m_max,temperature_2m_min',
        forecast_days: '1',
        timezone: 'auto'
      });

      return fetchJson('https://api.open-meteo.com/v1/forecast?' + params.toString()).then(function (weatherData) {
        return normalizeWeatherPayload(query, location, weatherData);
      });
    });
  }

  function fetchJson(url) {
    if (typeof window.fetch !== 'function') {
      return Promise.reject(new Error('当前浏览器不支持天气请求，请升级浏览器后重试。'));
    }

    const timeoutMs = 8000;

    return withTimeout(
      window.fetch(url, {
        headers: {
          Accept: 'application/json'
        }
      }).then(function (response) {
        if (!response.ok) {
          throw new Error('天气服务暂时不可用，请稍后再试。');
        }

        return response.json();
      }),
      timeoutMs,
      '天气请求超时，请稍后刷新重试。'
    );
    }

  function withTimeout(promise, timeoutMs, message) {
    return new Promise(function (resolve, reject) {
      const timer = window.setTimeout(function () {
        reject(new Error(message));
      }, timeoutMs);

      promise.then(function (value) {
        window.clearTimeout(timer);
        resolve(value);
      }).catch(function (error) {
        window.clearTimeout(timer);
        reject(error);
      });
    });
  }

  function normalizeWeatherPayload(query, location, weatherData) {
    const current = weatherData && weatherData.current ? weatherData.current : {};
    const daily = weatherData && weatherData.daily ? weatherData.daily : {};
    const weather = getWeatherInfo(current.weather_code, current.is_day);
    const currentTemp = formatNumber(current.temperature_2m);
    const feelsLike = formatTemperature(current.apparent_temperature);
    const humidity = formatPercent(current.relative_humidity_2m);
    const wind = formatWind(current.wind_speed_10m);
    const high = daily.temperature_2m_max && daily.temperature_2m_max.length ? daily.temperature_2m_max[0] : null;
    const low = daily.temperature_2m_min && daily.temperature_2m_min.length ? daily.temperature_2m_min[0] : null;
    const updatedAt = formatClock(current.time);

    return {
      kind: weather.kind,
      period: current.is_day === 1 ? '白天' : '夜间',
      location: formatLocation(location, query),
      temperature: currentTemp,
      summary: weather.label + '，体感 ' + feelsLike,
      shortLabel: weather.shortLabel,
      feelsLike: feelsLike,
      humidity: humidity,
      wind: wind,
      range: formatRange(high, low),
      meta: updatedAt ? '更新于 ' + updatedAt + ' · Open-Meteo' : '数据源：Open-Meteo'
    };
  }

  function formatLocation(location, fallback) {
    const parts = [];

    [location && location.name, location && location.admin1, location && location.country].forEach(function (part) {
      if (part && parts.indexOf(part) === -1) {
        parts.push(part);
      }
    });

    return parts.length ? parts.join(' · ') : fallback;
  }

  function formatNumber(value) {
    const number = Number(value);
    return Number.isFinite(number) ? String(Math.round(number)) : '--';
  }

  function formatTemperature(value) {
    const number = formatNumber(value);
    return number === '--' ? '--' : number + '°C';
  }

  function formatPercent(value) {
    const number = formatNumber(value);
    return number === '--' ? '--' : number + '%';
  }

  function formatWind(value) {
    const number = formatNumber(value);
    return number === '--' ? '--' : number + ' km/h';
  }

  function formatRange(high, low) {
    const highText = formatTemperature(high);
    const lowText = formatTemperature(low);

    if (highText === '--' && lowText === '--') {
      return '--';
    }

    return highText + ' / ' + lowText;
  }

  function formatClock(value) {
    if (typeof value !== 'string') return '';

    const parts = value.split('T');
    if (parts.length < 2) return '';

    return parts[1].slice(0, 5);
  }

  function getWeatherInfo(code, isDay) {
    const weatherCode = Number(code);
    const daytime = Number(isDay) === 1;

    if (weatherCode === 0) {
      return {
        kind: 'clear',
        label: daytime ? '晴朗' : '晴夜',
        shortLabel: daytime ? '晴' : '夜'
      };
    }

    if (weatherCode === 1) {
      return { kind: 'cloud', label: '晴间多云', shortLabel: '云' };
    }

    if (weatherCode === 2) {
      return { kind: 'cloud', label: '局部多云', shortLabel: '云' };
    }

    if (weatherCode === 3) {
      return { kind: 'cloud', label: '阴天', shortLabel: '阴' };
    }

    if ([45, 48].indexOf(weatherCode) !== -1) {
      return { kind: 'fog', label: '有雾', shortLabel: '雾' };
    }

    if ([51, 53, 55, 56, 57].indexOf(weatherCode) !== -1) {
      return { kind: 'rain', label: '毛毛雨', shortLabel: '雨' };
    }

    if ([61, 63, 65, 66, 67, 80, 81, 82].indexOf(weatherCode) !== -1) {
      return { kind: 'rain', label: '下雨', shortLabel: '雨' };
    }

    if ([71, 73, 75, 77, 85, 86].indexOf(weatherCode) !== -1) {
      return { kind: 'snow', label: '下雪', shortLabel: '雪' };
    }

    if ([95, 96, 99].indexOf(weatherCode) !== -1) {
      return { kind: 'storm', label: '雷暴', shortLabel: '雷' };
    }

    return { kind: 'clear', label: '天气稳定', shortLabel: '晴' };
  }

  initWeatherCard();
})();
